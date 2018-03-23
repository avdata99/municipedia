Instalar Municipedia
====================

Municipedia es un software libre.


Inicializar base Postgres 
=========================

Municipedia usa postgres para optimizar el uso con GeoDjango. 
Para esto se requiere `Postgis <https://postgis.net/install/>`_.

.. code:: bash 
    $ sudo su - postgres
    $ psql

y ejecutar la siguientes directivas sql

.. code:: sql

    CREATE EXTENSION postgis;
    CREATE DATABASE municipedia;
    CREATE USER municipedia WITH PASSWORD 'municipedia';
    ALTER ROLE municipedia SET client_encoding TO 'utf8';
    ALTER ROLE municipedia SET default_transaction_isolation TO 'read committed';
    ALTER ROLE municipedia SET timezone TO 'UTC';
    GRANT ALL PRIVILEGES ON DATABASE municipedia TO municipedia;