from django.contrib import admin
from .models import DatoCrudo


@admin.register(DatoCrudo)
class DatoCrudoAdmin(admin.ModelAdmin):
    list_display = ['nombre', 'id', 'archivo', 'url_sitio_descarga', 'created']
    search_fields = ['nombre']
    
