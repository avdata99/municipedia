from django.contrib import admin
from django.contrib.gis import admin as gisadmin


class MunicipediaOSMGeoAdmin(gisadmin.OSMGeoAdmin):
    """ admin para mapas en modelos con GIS """
    
    # el template de admin.OSMGeoAdmin que anda OK
    # map_srid = 3857  # al parecer la que usa gmaps
    # map_srid = 4326  # es otra opcion usada por google
    map_template = 'gis/admin/osm.html'  # el que incluye calles y ciudades de OSM
    # map_template = 'gis/admin/openlayers.html'  # vacio, el original
    # default_lat = -31
    # default_lon = -64
    default_lon = -7144296
    default_lat = -3682101
    
    default_zoom = 14
    map_width = 800
    map_height = 500