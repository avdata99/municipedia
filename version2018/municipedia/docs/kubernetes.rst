Despliegue en Google Cloud
==========================

Uso `este turorial <https://cloud.google.com/kubernetes-engine/docs/tutorials/hello-app>`_ para 
desplegar este proyecto en Google Cloud vía *kubernetes*.

Primero cree un nuevo proyecto en Google Cloud (con la facturación habilitada)
`Sobre Ubuntu <https://cloud.google.com/sdk/docs/quickstart-debian-ubuntu>`_ instale *google-cloud-sdk*

.. code:: bash

  # Create an environment variable for the correct distribution
  export CLOUD_SDK_REPO="cloud-sdk-$(lsb_release -c -s)"

  # Add the Cloud SDK distribution URI as a package source
  echo "deb http://packages.cloud.google.com/apt $CLOUD_SDK_REPO main" | sudo tee -a /etc/apt/sources.list.d/google-cloud-sdk.list

  # Import the Google Cloud Platform public key
  curl https://packages.cloud.google.com/apt/doc/apt-key.gpg | sudo apt-key add -

  # Update the package list and install the Cloud SDK
  sudo apt-get update && sudo apt-get install google-cloud-sdk

Inicialicé el SDK 

.. code:: bash

  gcloud init

Allí se define el proyecto a usar y la zona del servidor donde va a correr el proyecto.
Tambien puede quedar configurado para que no lo pida de nuevo a futuro.

.. code:: bash

  gcloud config set project [PROJECT_ID]
  gcloud config set compute/zone us-central1-b

Compilo el contenedor de la app con el tag específico. 
El prefijo gcr.io se refiere al *Google Container Registry*

.. code:: bash
  export PROJECT_ID="$(gcloud config get-value project -q)"
  docker build -t gcr.io/${PROJECT_ID}/municipedia:v1 .

Subir la nueva imagen tageada

.. code:: bash
  gcloud docker -- push gcr.io/${PROJECT_ID}/municipedia:v1

Probando en el entorno local el contenedor compilado

.. code:: bash

  docker run --rm -p 8080:8080 gcr.io/${PROJECT_ID}/municipedia:v1


Crear el cluster para hacer correr las imágenes
.. code:: bash

  gcloud container clusters create municipedia-cluster --num-nodes=2
  # obtener las credenciales despues de creados
  # gcloud container clusters get-credentials municipedia-cluster

Resultado
.. 

  gcloud container clusters create municipedia-cluster --num-nodes=2

  WARNING: Starting in Kubernetes v1.10, new clusters will no longer get compute-rw and storage-ro scopes added to what is specified in --scopes (though the latter will remain included in the default --scopes). To use these scopes, add them explicitly to --scopes. To use the new behavior, set container/new_scopes_behavior property (gcloud config set container/new_scopes_behavior true).
  Creating cluster municipedia-cluster...done.                                                                                                                                                                      

  Created [https://container.googleapis.com/v1/projects/municipedia-199015/zones/us-east4-b/clusters/municipedia-cluster].

  To inspect the contents of your cluster, go to: https://console.cloud.google.com/kubernetes/workload_/gcloud/us-east4-b/municipedia-cluster?project=municipedia-199015
  kubeconfig entry generated for municipedia-cluster.

  NAME                 LOCATION    MASTER_VERSION  MASTER_IP      MACHINE_TYPE   NODE_VERSION  NUM_NODES  STATUS
  municipedia-cluster  us-east4-b  1.8.8-gke.0     35.199.44.228  n1-standard-1  1.8.8-gke.0   2          RUNNING


.. code:: bash

.. code:: bash

.. code:: bash

.. code:: bash

.. code:: bash

.. code:: bash