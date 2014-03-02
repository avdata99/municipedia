
        <!-- Site Description -->
        <div class="presentation container">
            <h2>Lista de sets de datos cargados</h2>
            
            <p class="jstfy">
                
                    <?php
                    
                    foreach ($refs as $r) 
                        {
                        
                        $tit = urlencode(str_replace(" ", "-", $r->titulo));
                        echo " <br/>[$r->fecha] <a href='/datos/referencia/$tit'>$r->titulo</a>";
                        /*
                        echo "<a href='/datos/download/$tit/0/csv'>CSV</a> ";
                        echo "<a href='/datos/download/$tit/0/xls'>XLS</a> ";
                        echo "<a href='/datos/download/$tit/0/json'>JSON</a> ";
                         * 
                         */
                        }
                    
                    
                    ?>
            </p>
            
            
        </div>
        