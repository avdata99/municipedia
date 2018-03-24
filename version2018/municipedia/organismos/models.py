from django.db import models
from municipios.models import Lugar
from tagulous.models import TagField


class OrganismoExterno(models.Model):
    ''' Organismos (oficiales o no) que usan o administran estos datos '''
    nombre = models.CharField(max_length=190)
    ambito_de_trabajo = models.ForeignKey(Lugar, null=True, blank=True, on_delete=models.SET_NULL)
    es_organismo_oficial = models.NullBooleanField(default=None)
    web_oficial_organismo = models.URLField(null=True, blank=True)
    
    tags = TagField()
    
    def __str__(self):
        return self.nombre


class IdentificadorExterno(models.Model):
    ''' si tenemos suerte los organismos que usan estos datos tienen un identificador '''
    organismo = models.ForeignKey(OrganismoExterno, on_delete=models.CASCADE)
    version = models.CharField(max_length=90, null=True, blank=True, help_text='algunos organismo ponen un código una vez y despues lo cambian')
    web_definicion_identificadores = models.URLField(null=True, blank=True)
    observaciones_publicas = models.TextField(null=True, blank=True)
    
    def __str__(self):
        return 'Ident {}'.format(self.organismo.nombre)


class IdentificadoresExternos(models.Model):
    ''' cada uno de los identificadores que estableció el organismo en una version específica '''
    lugar = models.ForeignKey(Lugar, on_delete=models.CASCADE)
    identificador = models.ForeignKey(IdentificadorExterno, on_delete=models.CASCADE)
    id_externo = models.CharField(max_length=90)
    
    def __str__(self):
        return '{} {} ({})'.format(self.id_externo, self.lugar.nombre, self.identificador.organismo.nombre)
