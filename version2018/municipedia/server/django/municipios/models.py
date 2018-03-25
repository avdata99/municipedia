from django.db import models
from django.contrib.gis.db import models as models_geo
from tagulous.models import TagField


class TipoLugar(models.Model):
    ''' pais, provincia, ciudad, partido y otras miles de denominaciones en el mundo '''
    nombre = models.CharField(max_length=190)
    
    def __str__(self):
        return self.nombre
    
    class Meta:
        verbose_name = 'Tipo de Lugar'
        verbose_name_plural = 'Tipos de Lugares'
    

class Lugar(models.Model):
    tipo = models.ForeignKey(TipoLugar, on_delete=models.CASCADE)
    pertenece_a = models.ForeignKey('self', null=True, blank=True, on_delete=models.SET_NULL)
    nombre = models.CharField(max_length=190, help_text='Nombre oficial')
    nombre_resumido = models.CharField(max_length=90, help_text='Nombre corto, informal y más amigable del lugar')
    
    latlong = models_geo.PointField(null=True, blank=True, help_text='Punto representativo del lugar en el mapa')
    poligono = models_geo.PolygonField(null=True, blank=True, help_text='Polígono del lugar en el mapa')
    
    tags = TagField()
    
    created = models.DateTimeField(auto_now_add=True)
    updated = models.DateTimeField(auto_now=True)
    
    def geo_breadcrumb(self):
        ret = [self]
        obj = self
        while obj.pertenece_a is not None:
            ret.append(obj.pertenece_a)
            obj = obj.pertenece_a
        return ret
    
    def __str__(self):
        return self.nombre_resumido if self.pertenece_a is None else '{} - {}'.format(self.pertenece_a.nombre_resumido, self.nombre_resumido)
    
    class Meta:
        verbose_name_plural = 'Lugares'