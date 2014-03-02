<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=114823935226083";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


        <!-- Site Description -->
        <div class="presentation container">
            <h2><span class="violet">La</span> enciclopedia de los municipios argentinos</h2>
            <p>contanos de tu ciudad</p>
            <div class="buscadorhome">
                <input class="nicetext" id="buscaor" type="text" placeholder="Buscá tu ciudad aquí ..."/>
                <div id="results" class="resulthome">
                    
                </div>
                
                
            </div>
            
            <div class='jstfy' style='margin-bottom: 30px'>
                <p>
                    <strong>Municipedia</strong> es una enciclopedia de datos, es como wikipedia pero con datos duros. 
                    Usamos sets de datos que estén abiertos al publico y los cargamos con un <a href='/datos'>asistente sencillo</a>
                    para que cualquiera pueda participar.
                </p>
                <p>
                    Todavía estamos en una versión inicial pero mas adelante podremos agregar visualizaciones a los datos, vamos
                    a poder calificar y valorar los datos para dejar solo los mejores.
                </p>
                <p>
                    Si tenes dudas, consultas, sugerencias o críticas escribime a municipedia@data99.com.ar. 
                    Gracias por cualquier colaboración
                </p>
                <p>
                    Si tenes datos de tu ciudad no dejes de compartirlos, solo se requiere conocer un poco
                    de planillas de cálculo.
                </p>
            </div>
            
            <div>
          
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
        </div>
        
        <script>
        $(document).ready(function() {
            $("#buscaor").on("input",function()
                {
                var jx = $.post("ajx/searchMuni", {muni:$(this).val()} );
                jx.done(function(data)
                    {
                    if (data.error !== "")
                        {
                        $("#results").html(data.error);
                        }
                    else
                        {
                        $("#results").html("");
                        $(data.munis).each(function()
                            {
                            var muni = this.municipio;
                            muni = muni.replace(/\ /g,"-");
                            var prov = this.provincia;
                            prov = prov.replace(/\ /g, "-");
                            var url = muni + "-en-la-provincia-de-" + prov;
                            var nombre = this.municipio + " en " + this.provincia;
                            $("#results").append("[<a href='"+url +"'>"+nombre+"</a>] ");
                            });
                        }
                    });
                });
           
           
           
          });
        </script>
        