
        <!-- Site Description -->
        <div class="presentation container">
            <h2>Referencia de los datos. <?=$ref->titulo?></h2>
            <p class="jstfy">Datos cargados por <?="$ref->twitter_name (<a href='http://twitter.com/$ref->twitter_user' target='_blank'>@$ref->twitter_user</a>)"?></p>
            <p class="jstfy">
                DESCARGAR: 
                    <?php
                    $tit = urlencode(str_replace(" ", "-", $ref->titulo));
                    echo "<a href='/datos/download/$tit/0/csv'>CSV</a> ";
                    echo "<a href='/datos/download/$tit/0/xls'>XLS</a> ";
                    echo "<a href='/datos/download/$tit/0/json'>JSON</a> ";
                    ?>
            </p>
            
            <p class="jstfy"><?=nl2br($ref->descripcion)?></p>
            <?php if ($ref->url) { ?>
            <p class="jstfy">Ver el origen de los datos <a target="_blank" href="<?=$ref->url?>">aquí</a></p> 
            <?php } else {?>
            <p class="jstfy">No se ha indicado un origen de datos</p> 
            <?php } ?>
        </div>
        