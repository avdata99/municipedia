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

Defino la variable de entorno y compilo el contenedor de la app.

.. code:: bash
  export PROJECT_ID="$(gcloud config get-value project -q)"
  docker build -t gcr.io/${PROJECT_ID}/municipedia:v1 





.. code:: bash
  





.. code:: bash






.. code:: bash