<?php echo "<?xml version='1.0' encoding='UTF-8'?>"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>http://municipedia.com/</loc>
        <lastmod><?php echo date("Y-m-14"); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>1</priority>
    </url>
    
    <url>
        <loc>http://municipedia.com/datos/referencias</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    <url>
        <loc>http://municipedia.com/datos</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    
    <?php foreach ($municipios as $muni) 
        {
        
        $m = str_replace(" ", "-", $muni->municipio);
        $p = str_replace(" ", "-", $muni->provincia);
        
    ?> 
        <url>
            <loc>http://municipedia.com/<?php echo "$m-en-la-provincia-de-$p" ?></loc>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    <?php } ?>
    
    <?php foreach ($referencias as $ref) 
        {
        
        $r = str_replace(" ", "-", $ref->titulo);
        
    ?> 
        <url>
            <loc>http://municipedia.com/datos/referencia/<?php echo "$r" ?></loc>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    <?php } ?>
    
</urlset>