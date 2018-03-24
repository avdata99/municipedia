Despliegue en Google Cloud
==========================

Uso `este turorial <https://cloud.google.com/kubernetes-engine/docs/tutorials/hello-app>`_ para 
desplegar este proyecto en Google Cloud vía *kubernetes*.

Otra opciones útiles:
 - docker + docker-compose con django: `aquí <https://docs.docker.com/compose/django/#connect-the-database>`_.
 - traducir compose a recursos kubernetes `<https://kubernetes.io/docs/tools/kompose/user-guide/>`_.
 - de docker a Google Cloud: `aquí <https://scotch.io/tutorials/google-cloud-platform-i-deploy-a-docker-app-to-google-container-engine-with-kubernetes>`_.
 - django + postgres + redis con minikube y google containers engine: `aquí <https://github.com/waprin/kubernetes_django_postgres_redis>`_.

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
Mi aplicación funciona sin problemas con docker-compose donde estan descriptos los servicios que necesito.
Kubernetes no usa los archivos de confugración de *docker-compose* (si con docker a secas).

Para pasar de yaml de compose a kubernetes existe `esto <https://github.com/kubernetes/kompose>`_.
Genero entonces un directorio kubernetes con los archivos generados.

.. code:: bash

  kompose convert -o kubernetes/

Ya tengo lista mis instrucciones para desplegar. Ahora creo el cluster donde se desplegará.
Esto prende especificamente los servidores/nodos solicitados y pueden verse en el panel de Google Cloud.

.. code:: bash

    gcloud container clusters create municipedia-cluster --num-nodes=2
    # despues de creado se pueden obtener las credenciales así
    gcloud container clusters get-credentials municipedia-cluster


Desplegar 
.. code:: bash
  # crear instancias para todos los archivos exportados desde 
  kubectl create -f kubernetes/
  # ver los pods creados
  kubectl get pods
  
  NAME                   READY     STATUS            RESTARTS   AGE
  db-6fnnnnf8f-xnnnj    1/1       Running            0          2m
  web-7nnnn86c-4nnns    0/1       ImagePullBackOff   0          2m

Podes ver la lista de instancias

.. code:: bash

  gcloud compute instances list
  NAME                                  ZONE        MACHINE_TYPE   PREEMPTIBLE  INTERNAL_IP  EXTERNAL_IP   STATUS
  gke-municipedia-cluster-default-8dj2  us-east3-b  n1-standard-1               10.150.0.3   35.199.32.42  RUNNING
  gke-municipedia-cluster-default-k3l4  us-east3-b  n1-standard-1               10.150.0.2   35.188.38.93  RUNNING

  
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