<?php
require_once("../config.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?=getenv('HOST')?> Malaysian Responder</title>
<meta name=viewport content="width=device-width, initial-scale=1">
<link href="//h.<?=getenv('HOST');?>/style.css" rel="stylesheet">
</head>
<body>
<p><a href=//d.<?=getenv('HOST')?>>Documentation</a></p>
<p><a href=//h.<?=getenv('HOST')?>>Home owner interface</a></p>
<p><a href=//g.<?=getenv('HOST')?>>Guard/responder interface</a></p>
<p><a href=//m.<?=getenv('HOST')?>>Management interface</a></p>
<p><a href=mailto:<?=getenv('M_EMAIL')?>>Email admin</a></p>
<footer><a href=https://github.com/kaihendry/myresponder>MIT licensed source code</a> version <?=getenv('COMMIT')?></footer>
</body>
</html>
