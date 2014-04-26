<?php 

$pages = array(
  	"webylon.info",  
  	"jecas.cz",  
  	"semantika.name",
  	"teststranek.kvalitne.cz",
  	"pehapko.cz",
  	"php.vrana.cz",
    "kod.djpw.cz",
  	);

foreach ($pages as $page) {
	# code...
}
?>
<!doctype html>
<meta charset="utf-8">
<title>Generátor PHP spritů z favicon</title>

<style>
	.bg {background-color: #DA3F94; display: inline-block;}
	.do-webu u {display: inline-block; width: 14px; height: 14px; vertical-align: middle;}
</style>

<link rel="stylesheet" href="./css-sprite.php">

<h1>Generátor PHP spritů z favicon webů</h1>

<p>Vztahuje se k <a href="http://jecas.cz/css-sprite">CSS sprite</a> na stránce <a href="http://jecas.cz">jecas.cz</a>.</p>

<?php
// Uložení favicon jako PNG

foreach ($pages as $page) {
	file_put_contents(
		str_replace(
			array(".", "/"), 
			"-", 
			$page
		) . ".png", 
		file_get_contents("http://www.google.com/s2/favicons?domain=" . $page)
	);
}


foreach (glob("*.png") as $filename) {
	if ($filename == "favicony.png") continue;
	$filename = basename($filename, ".png");
?>	

<h2>Ikona <code><?=$filename?></code></h2>
<pre><code><?=htmlspecialchars("<a href='' class='do-webu $filename'><u></u> $filename</a>")?></code></pre>
<div class="bg">
	<a href="" class="do-webu <?=$filename?>"><u></u> <?=$filename?></a>
</div>


<?php } ?>