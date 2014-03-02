<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=114823935226083";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

        <!-- Site Description -->
        <div class="presentation container jstfy">
            <h2>Datos</h2>
            <p>
                Municipedia es una enciclopedia de datos colaborativa. Podes ver la <a href="/datos/referencias">lista de sets de datos cargados</a> y descargarlos <a href="/datos/referencias">aquí</a>
            </p>
            <p>Tambien podes acceder a cargar datos de uno o más municipios simultáneamente siguiendo estos pasos.</p>
            <hr style="clear:both">
            <p>
                1.- Registrarte en municipedia vía twitter
                <?php 
                if ($user && $user->twitter_user)
                    echo " (listo @$user->twitter_user)";
                else
                    echo "<a href='/twtcback/accesstwitter'>aquí</a> (por ahora el único medio de acceso a la carga de datos)";
                ?>
            </p>
            <hr style="clear:both">
            <p> 
                2.- Crear una copia de nuestro 
                <a target="_blank" href="https://docs.google.com/spreadsheet/ccc?key=0AtsaNutQ5ZYhdDRWNHd0MjIzWkhNb0FXMzBjYllEd0E&newcopy">documento base de municipios</a>
                (requiere que conozcas a nivel básico google drive).
                Si no tienes una cuenta de gmail te recomendamos que crees una, será muy util para hacer y compartir 
                documentos en línea.<br/>
                <img src="/assets/img/paso10.png" class="imgdatos" />
            </p>
            <hr style="clear:both">
            <p> 
                Crea en el documento una columna por cada dato que vas a cargar. No uses descripciones muy largas, en lugar de 
                "cantidad de habitantes en 1980 por censo provincial" usa "Poblacion 1980", en un paso posterior podrás hacer una 
                descricpión mas compleja y detallada de el set de datos que estás cargando.<br/>
                <img src="/assets/img/paso20.png" class="imgdatos" />
            </p>
            <hr style="clear:both">
            <p> 
                Seguramente tu análisis de datos no incluye información sobre todos los municipios, elimina
                entonces los que no vas a usar. Asegúrate de no mezclar por error los datos de la primera
                columna "ID". Elimina las filas completas, que solo queden aquellos registros que vas a utilizar.<br/>
                <img src="/assets/img/paso30.png" class="imgdatos" />
            </p>
            <hr style="clear:both">
            
            <p> 
                Una vez que termines de cargar los datos es necesario que hagas pública la planilla para 
                que nuestro sistema pueda acceder a leerla. Para esto clickea el menú "Archivo", opción "Publicar
                en la web".
                Presionas "Iniciar publicación" y luego eliges el formato CSV.<br/>
                <img src="/assets/img/paso40.png" class="imgdatos" />
            </p>
            <hr style="clear:both">
            
            <p> 
                La URL (direccion vía web) para acceder a la planilla es la que se indica al final de la planilla.
                Cópiala antes de cerrar este formulario de publicación. Debes pegarla aquí, a continuación.<br/>
                <img src="/assets/img/paso50.png" class="imgdatos" />
            </p>
            <hr style="clear:both">
            
            <p id="frm">
                URL de la planilla publicada
                <br/><textarea style="width:490px" rows="6" placeholder="URL larga de google drive" id="urldrive"></textarea>
                
                <br/>Titulo del set de datos
                <br/><input type="text" placeholder="titulo" id="titulo"/>
                
                <br/>Descripción
                <br/><textarea style="width:290px" rows="6" id="descripcion"></textarea>
                
                <br/>URL de referencia, la web donde se podrá validar los datos
                <br/><input type="text" placeholder="URL de referencia" id="urlref" style="width:400px"/>
                
            </p>
            
            <div id="divbtok" class="call-to-action-text span12" style="margin: 30px 0">
                <div class="ca-text"><p>Cargar datos al sistema</p></div>
                <div class="ca-button"><a id="savedata">Cargar!</a></div>
            </div>
            
            <div class="call-to-action-text span12" style="margin: 30px 0">
                <div id="resultado" class="ca-text">

                </div>
            </div>
            
            <div style="margin-top: 60px;">
                Dudas o consultas por email a andres@data99.com.ar, tambien 
                en <a target="_blank" href="http://twitter.com/elnomoteta">@elnomoteta</a> 
                y <a target="_blank" href="http://twitter.com/municipedia">@municipedia</a>
            </div>
            
            
            <a href="https://twitter.com/municipedia" class="twitter-follow-button" data-show-count="true" data-lang="es" data-size="large">
Seguir a @municipedia
</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

<div class="fb-like" data-href="http://facebook.com/pages/Municipedia/499416823483441" 
     data-width="450" data-layout="button_count" data-show-faces="true" data-send="true"></div>
          
<div class="g-follow" data-annotation="bubble" data-height="20" 
     data-href="//plus.google.com/u/0/b/113383814976709062786/113383814976709062786" 
     data-rel="publisher"></div>

<!-- Place this tag after the last widget tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
        </div>
        
        
        <script>
        $(document).ready(function() {
            $("#savedata").click(function()
                {
                var errores = "";    
                var tit=$("#titulo").val();
                if (tit === "") errores = "No hay titulo";
                    
                var descr=$("#descripcion").val();
                if (descr === "") errores = "No hay descripcion";
                    
                var urld = $("#urldrive").val();    
                if (urld === "") errores = "No hay insertaste el set de datos";
                
                if (errores !== "")
                    {
                    alert(errores);
                    return false;
                    }
                    
                $("#savedata").hide();
                
                var jx = $.post("ajx/addDataSet", 
                    {
                    titulo: tit
                    ,descripcion: descr
                    ,urldrive: urld
                    ,urlref: $("#urlref").val()
                    ,
                    });
                    
                jx.fail(function(data){
                    $("#resultado").html("FALLO");
                    $("#savedata").show();
                });
                
                jx.done(function(data)
                    {
                    $("#savedata").show();    
                    if (data.error !== "")
                        {
                        $("#resultado").html("<p>ERROR: " + data.error + "</p>");
                        $("#resultado").append("<p>POST: " + data.pst + "</p>");
                        $("#resultado").append("<p>JSON: " + data.json + "</p>");
                        }
                    else
                        {
                        $("#divbtok").hide();
                        $("#frm").hide();
                        $("#resultado").html("<p>TODO OK<p>");
                        $("#resultado").append("<p>Gracias, tus datos estaran disponibles en minutos en la ficha de cada municipio<p>");
                        // TODO mostrar esto $("#resultado").append("<p>Ya puedes ver <a href=''>la ficha de su set de datos aqui</a><p>");
                        $("#resultado").append("<p>El cache del sitio puede ser un poco persistente, quizas esto demore la visualizacion de estos nuevos datos</a><p>");
                        $("#resultado").append("<p>Si lo deseas puedes <a href='/datos'>cargar mas datos</a><p>");
                        }
                    });
                });
           
           
           
          });
        </script>
        