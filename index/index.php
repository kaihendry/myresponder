<?php
require_once("../config.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?=$HOST;?> Malaysian Responder</title>
<meta name=viewport content="width=device-width, initial-scale=1">
<link href="//h.<?=$HOST;?>/style.css" rel="stylesheet">
<script src=main.js></script>
</head>
<body>
<p><a href=//h.<?=$HOST;?>>Home owner interface</a></p>
<p><a href=//g.<?=$HOST;?>>Guard/responder interface</a></p>
<p><a href=//m.<?=$HOST;?>>Management interface</a></p>
<p><a href=mailto:<?=$ADMIN_EMAIL;?>>Email admin</a></p>
<p><a href="https://github.com/kaihendry/myresponder">Source code</a></p>
</body>
</html>
