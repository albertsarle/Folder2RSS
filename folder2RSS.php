<?php
$basePath = '/media/Lacie320';
$xmlPath = '/var/www/terrassa.guifi.net/ftp.xml';
$ftpUrl = "ftp://10.139.7.162";
$ftpTitle = 'FTP Terrassa';
$description = 'Un disc compartit a la xarxa lliure guifi.net des de Terrassa';
$avui = date('D, d M Y g:i:s O', time());

$xmlheader = <<<XMLHEADER
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
    <channel>
        <title>$ftpTitle</title>
        <link>$ftpUrl</link>
        <description>$description</description>
        <language>catala</language>
        <pubDate>$avui</pubDate>
        <lastBuildDate>$avui</lastBuildDate>
XMLHEADER;

$xmlfooter = <<<XMLFOOTER
    </channel>
</rss>
XMLFOOTER;


exec('find '.$basePath.'/public/ -type f   -printf "%A+·" -print  -cnewer '. $xmlPath .' |sort -nr -k 1', $entrada);

if (count($entrada)>0) {
  $fp = fopen($xmlPath, 'w');
  fwrite($fp, header('Content-type: text/xml'));
  fwrite($fp, $xmlheader);

  foreach ($entrada as $fitxer) {
    $parts = explode ("·", $fitxer);
    fwrite($fp,'<item>
                  <title>'. str_replace($basePath, "", $parts[1]) .'</title>
                  <link>'. str_replace($basePath, $ftpUrl, $parts[1]).'</link>
                  <description>'. $parts[0] .'</description>
                </item>');
  }
  fwrite($fp, $xmlfooter);
  fclose($fp);
}
?> 


