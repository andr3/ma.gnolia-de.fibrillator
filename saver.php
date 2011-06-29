<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Ma.gnolia de.fibrillator</title>
    <link rel="stylesheet" type="text/css" href="fl.owerpower.css" />
</head>
  <body>
    <h1>Ma.gnolia de.fibrillator</h1>
<?php
set_time_limit ( 300 );

$head = <<<END
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    </head>
    <body>
END;

$footer = <<<END
</body>
</html>
END;

$hash = md5 ($_POST['content']);

$fp = fopen ( 'cache/'.$hash.'.html', 'w' ); 

fwrite ( $fp, $head.urldecode($_POST['content']).$footer);

fclose ($fp);






echo "<p>Here are your bookmarks.</p>";


$uri_base       = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);
$uri            = $uri_base . '/cache/'.$hash.'.html';
$urirss         = $uri_base . '/cache/'.$hash.'.xml';


$json = 'http://workshop.andr3.net/ufs/?filter=hentry&format=json&uri='.$uri;

$dog = curl_init();
curl_setopt ( $dog, CURLOPT_URL, $json );
curl_setopt ( $dog, CURLOPT_RETURNTRANSFER, 1 );

$json_content = curl_exec ($dog);

$fp_json = fopen ( 'cache/'.$hash.'.json', 'w' );
fwrite ( $fp_json, $json_content );
fclose ($fp_json);

//-----
$rss = 'http://workshop.andr3.net/ufs/?filter=hentry&format=rss&uri='.$uri;

$dog = curl_init();
curl_setopt ( $dog, CURLOPT_URL, $rss );
curl_setopt ( $dog, CURLOPT_RETURNTRANSFER, 1 );

$rss_content = curl_exec ($dog);

$fp_rss = fopen ( 'cache/'.$hash.'.rss.xml', 'w' );
fwrite ( $fp_rss, $rss_content );
fclose ($fp_rss);

//-----

$bookmarks = 'http://lab.madgex.com/api/xfolktobookmark1_0/?url='.$uri.'&format=bookmark+import+HTML&folder=Ma.gnolia+de.fibrillator';

$dog = curl_init();
curl_setopt ( $dog, CURLOPT_URL, $bookmarks );
curl_setopt ( $dog, CURLOPT_RETURNTRANSFER, 1 );

$bookmarks_content = curl_exec ($dog);

$fp_bookmarks = fopen ( 'cache/'.$hash.'.bookmarks.html', 'w' );
fwrite ( $fp_bookmarks, $bookmarks_content );
fclose ($fp_bookmarks);

//-----
echo '<ul>';
echo '<li><a href="./cache/'.$hash.'.html">Webpage with microformats (hAtom+xfolk)</a></li>';
echo '<li><a href="./cache/'.$hash.'.bookmarks.html">Bookmarks.html file</a> (to use with Firefox and other tagging services. ex: <a href="http://links.sapo.pt/import">SAPO Links</a>)</li>';
echo '<li><a href="./cache/'.$hash.'.rss.xml">RSS</a></li>';
echo '<li><a href="./cache/'.$hash.'.json">JSON</a></li>';
echo '</ul>';

echo '<p>1. Bookmark these links in your browser.</p>';
echo '<p>2. Save the pages to your computer as well.</p>';
echo '<hr />';
echo '<h2>Acknowledgment</h2><p>The bookmarks.html file was created courtesy of <a href="http://www.glennjones.net/Home/">Glenn Jones</a>\'s <a href="http://lab.madgex.com/ufXtract/bookmarks.aspx">script to convert from xfolk to bookmarks.html</a>.</p>';


?>

    <hr />
    <p class="footer">brought to you by <a href="http://andr3.net">andr3.net</a></p>
</body>
</html>
