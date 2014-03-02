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
            <h2><?=$municipio?></h2>
            <p><?=$otros?></p>
            
            <div class="row">
                <div class="span6">
                    <div id="map_canvas" style="width:100%; height:400px"></div>
                </div>
                
                <div class="span6 dataficha">
                    <?="<span>$muni->jefe_categoria:</span> $muni->jefe";?>
                    <br/><span>Fundación:</span> <?="$muni->fundacion_dia/$muni->fundacion_mes/$muni->fundacion_anio $muni->fundacion_descripcion"?>
                    <br/><span>Web</span>: <?="<a target='_blank' href='$muni->web'>$muni->web</a>";?>
                    <br/><span>Direccion</span>: <?="$muni->direccion ($muni->cp)";?>
                    <?php foreach ($telefonos as $tel) { ?>
                        <br/><span>Telefono:</span> <?="<a href='tel:$tel->telefono'>$tel->telefono</a> $tel->descripcion";?>
                    <?php } ?>
                    
                    <?php foreach ($mails as $mail) { ?>
                        <br/><span>Email:</span> <?="<a href='mailto:$mail->email'>$mail->email</a> $mail->descripcion";?>
                    <?php } ?>    
                        
                </div>
                
                
                
            </div>
            
            <div class="row" data-muniid="<?=$muni->id?>" id="otros">
                
                    
                
            </div>
            
            
        </div>
        
        
<script type="text/javascript">
      function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(<?=$muni->latitud?>, <?=$muni->longitud?>),
          zoom: 14,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);
      }
</script>

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

<script>
$(document).ready(function() {
    //traer los datos resumids
    var muni_id = $("#otros").data("muniid");
    var jx = $.getJSON("assets/datas/" + muni_id + ".json");
     jx.done(function(data)
        {
        $("#otros").html("");
        var myhtml = '';
        $(data).each(function()
            {
            if (this.length > 0) 
                {
                
                
            myhtml += '<div class="span3 dataficha">';
            var tit = this[0].titulo;
            var urldata = tit.replace(/\ /g,"-");
            myhtml += "<b><a href='/datos/referencia/"+urldata+"'>"+tit+"</a></b> <strong><?=$muni->municipio?></strong>";
            myhtml += "<br/> Download: <a href='/datos/download/"+urldata+"/"+muni_id+"/csv'>CSV</a> ";
            myhtml += "<a href='/datos/download/"+urldata+"/"+muni_id+"/xls'>XLS</a> ";
            myhtml += "<a href='/datos/download/"+urldata+"/"+muni_id+"/json'>JSON</a> ";
            
            for (var prop in this[0]) 
                {
                if (this[0].hasOwnProperty(prop)) 
                    {
                    if (prop === "id" || prop === "titulo" || prop === "descripcion" || prop === "tabla" || prop === "url") continue;
                    if (prop === "referente_id" || prop === "autor_id") continue;
                    if (prop.indexOf("link_") > -1) continue;
                    myhtml += "<br/><b>"+prop+":</b> "+this[0][prop];
                    }
                }
            myhtml += "</div>";
            }
            });
        $("#otros").append(myhtml); 
        });

         });
</script>