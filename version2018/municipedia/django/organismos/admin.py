from django.contrib import admin
from .models import OrganismoExterno, IdentificadorExterno, IdentificadoresExternos

@admin.register(OrganismoExterno)
class OrganismoExternoAdmin(admin.ModelAdmin):
    list_display = ['nombre', 'web_oficial_organismo']
    search_fields = ['nombre', 'web_oficial_organismo']
    list_filter = ['es_organismo_oficial']


@admin.register(IdentificadorExterno)
class IdentificadorExternoAdmin(admin.ModelAdmin):
    list_display = ['organismo', 'version']
    search_fields = ['organismo__nombre']
    list_filter = ['organismo']


@admin.register(IdentificadoresExternos)
class IdentificadoresExternosAdmin(admin.ModelAdmin):
    list_display = ['id_externo', 'lugar', 'identificador']
    search_fields = ['id_externo', 'lugar__nombre']
    list_filter = ['lugar', 'identificador__organismo']
    

