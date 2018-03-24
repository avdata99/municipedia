from django.db import models
import requests
import os
import tempfile
from django.core.files import File
from urllib.parse import urlparse
from municipios.models import Lugar
from tagulous.models import TagField


class DatoCrudo(models.Model):
    ''' cada uno de los datos que descargamos antes de procesarlo '''
    nombre = models.CharField(max_length=190)
    ambitos_incluidos = models.ManyToManyField(Lugar, help_text='Lugares vinculados al dato en cuestion')
    archivo = models.FileField(upload_to='datos/', blank=True)
    # el URLField como es un VARCHAR tiene limitaciones molestas 
    url_sitio_descarga = models.TextField(null=True, blank=True)
    url_archivo = models.TextField(null=True, blank=True)
    observaciones_link = models.TextField(null=True, blank=True, help_text='Observaciones sobre la descarga y el sitio original')

    tags = TagField()
    
    created = models.DateTimeField(auto_now_add=True)
    updated = models.DateTimeField(auto_now=True)
    
    def __str__(self):
        return self.nombre

    def download(self):
        ''' descargar lo que este en URL externa y grabarlo como local '''

        r = requests.get(self.url_archivo)
        filename = os.path.basename(urlparse(self.url_archivo).path)

        tf = tempfile.SpooledTemporaryFile(max_size=50000000)  # hasta 50K queda en memoria, no escribe a /tmp
        tf.write(r.content)
        django_file = File(tf)

        self.archivo.save(filename, django_file, save=True)
        tf.close()  # borra el temporal


    def save(self, *args, **kwargs):
        # descargar el archivo si se puso la URL y no el archivo
        if self.url_archivo and (not self.archivo or self.archivo == ''):
            self.download()
        super().save(*args, **kwargs)

    class Meta:
        verbose_name = 'Dato crudo'
        verbose_name_plural = 'Datos crudos'
        

class ScreenDatoCrudo(models.Model):
    ''' screen del dato original en su sitio '''
    dato = models.ForeignKey(DatoCrudo, on_delete=models.CASCADE)
    imagen = models.ImageField(upload_to='imagenes-datos/')
    observaciones = models.TextField(null=True, blank=True, help_text='Observaciones de la imagen')
    
    def __str__(self):
        return self.imagen.filename

    class Meta:
        verbose_name = 'ScreeShot de dato crudo'
        verbose_name_plural = 'ScreeShots de dato crudo'