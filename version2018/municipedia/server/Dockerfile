FROM python:3.5
ENV PYTHONUNBUFFERED 1
RUN mkdir /code
WORKDIR /code

# instalar las loibrerías python necesarias para el proyecto (django y otros)
ADD ./django/ /code/
RUN pip install --upgrade pip
RUN pip install -r requirements.txt

# meter las librerías que necesite el sistema operativo
RUN apt-get update && apt-get install apt-utils binutils libproj-dev gdal-bin --assume-yes


