Despliegue en Google Cloud
==========================

Uso `este turorial <https://cloud.google.com/kubernetes-engine/docs/tutorials/hello-app>`_ para 
desplegar este proyecto en Google Cloud vía *kubernetes*.

Otra opciones útiles: 
 - docker + docker-compose con django: `aquí <https://docs.docker.com/compose/django/#connect-the-database>`_.
 - de docker a Google Cloud: `aquí <https://scotch.io/tutorials/google-cloud-platform-i-deploy-a-docker-app-to-google-container-engine-with-kubernetes>`_.

Activar el proyecto en Google Cloud
-----------------------------------

Primero cree un nuevo proyecto en Google Cloud (con la facturación habilitada) en 
`kubernetes engine <https://console.cloud.google.com/projectselector/kubernetes>`_.

Instalar el SDK de Google Cloud
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Seguí este tutorial `sobre Ubuntu <https://cloud.google.com/sdk/docs/quickstart-debian-ubuntu>`_ 
e instale *google-cloud-sdk*.

.. code:: bash

  # Create an environment variable for the correct distribution
  export CLOUD_SDK_REPO="cloud-sdk-$(lsb_release -c -s)"

  # Add the Cloud SDK distribution URI as a package source
  echo "deb http://packages.cloud.google.com/apt $CLOUD_SDK_REPO main" | sudo tee -a /etc/apt/sources.list.d/google-cloud-sdk.list

  # Import the Google Cloud Platform public key
  curl https://packages.cloud.google.com/apt/doc/apt-key.gpg | sudo apt-key add -

  # Update the package list and install the Cloud SDK
  sudo apt-get update && sudo apt-get install google-cloud-sdk kubectl

Inicialicé el SDK 

.. code:: bash

  gcloud init

Allí se define el proyecto a usar y la zona del servidor donde va a correr el proyecto.
Tambien puede quedar configurado para que no lo pida de nuevo a futuro.

.. code:: bash

  gcloud config set project [PROJECT_ID]
  gcloud config set compute/zone us-central1-b

Re-compilar mi contenedor
-------------------------

Ya con la app funcionando en docker vuelvo a compilarla pensando en subir a google cloud.

Compilo el contenedor de la app con el tag específico. 
El prefijo gcr.io se refiere al *Google Container Registry*.
Podes despues ver tus imágenes privadas en: https://console.cloud.google.com/gcr

.. code:: bash

  export PROJECT_ID="$(gcloud config get-value project -q)"
  docker build -t gcr.io/${PROJECT_ID}/municipedia:v1 .

Subir la nueva imagen tageada.

.. code:: bash

  gcloud docker -- push gcr.io/${PROJECT_ID}/municipedia:v1
  
  # luego para actualizar hay que recompilar con nuevo tag
  docker build -t gcr.io/${PROJECT_ID}/municipedia:v2 .
  # y subir la nueva imagen
  gcloud docker -- push gcr.io/${PROJECT_ID}/municipedia:v2
  # aplicar la actualizacion a tu cluster
  kubectl set image deployment/municipedia-web municipedia-web=gcr.io/${PROJECT_ID}/municipedia:v2

Probando en el entorno local el contenedor compilado

.. code:: bash

  docker run --rm -p 8000:8000 gcr.io/${PROJECT_ID}/municipedia:v1


Crear el cluster para hacer correr las imágenes. 
Esto prende especificamente los servidores/nodos solicitados y pueden verse en el panel de Google Cloud.

.. code:: bash

  gcloud container clusters create municipedia-cluster --num-nodes=2
  # despues de creado se pueden obtener las credenciales así
  gcloud container clusters get-credentials municipedia-cluster

Resultado de la creación del cluster
.. 

  gcloud container clusters create municipedia-cluster --num-nodes=2

  WARNING: Starting in Kubernetes v1.10, new clusters will no longer get compute-rw and storage-ro scopes added to what is specified in --scopes (though the latter will remain included in the default --scopes). To use these scopes, add them explicitly to --scopes. To use the new behavior, set container/new_scopes_behavior property (gcloud config set container/new_scopes_behavior true).
  Creating cluster municipedia-cluster...done.                                                                                                                                                                      

  Created [https://container.googleapis.com/v1/projects/municipedia-nnnnn/zones/us-east3-b/clusters/municipedia-cluster].

  To inspect the contents of your cluster, go to: https://console.cloud.google.com/kubernetes/workload_/gcloud/us-east3-b/municipedia-cluster?project=municipedia-nnnnnn
  kubeconfig entry generated for municipedia-cluster.

  NAME                 LOCATION    MASTER_VERSION  MASTER_IP      MACHINE_TYPE   NODE_VERSION  NUM_NODES  STATUS
  municipedia-cluster  us-east3-b  1.8.8-gke.0     35.19.144.128  n1-standard-1  1.8.8-gke.0   2          RUNNING

Podes ver la lista de instancias

.. code:: bash

  gcloud compute instances list

Hacer el deploy de mi aplicación a estos nuevos servidores.

.. code:: bash

  kubectl run municipedia-web --image=gcr.io/${PROJECT_ID}/municipedia:v1 --port 8000
  # ver el estatus de estos servicios.
  kubectl get pods
  
Poner un balanceador adelante para exponer esta aplicación a ala web.

.. code:: bash

  kubectl expose deployment municipedia-web --type=LoadBalancer --port 80 --target-port 8000
  # ver el estado del servicios
  kubectl get service
  

Limpiar todo para no gastar
---------------------------

Borrar todo lo hecho para no gastar.

.. code:: bash

  kubectl delete service municipedia-web
  # Esperar que el balanceador termine su trabajo antes de borrarlo.
  # El balanceador se borra asincrónicamente
  # Se puede seguir este proceso con el comando
  gcloud compute forwarding-rules list

  # Borrar finalmente el cluster. Este comando elimina todas las máquinas virtuales, discos y recursos de red 
  gcloud container clusters delete municipedia-cluster
  
.. code:: bash

.. code:: bash