<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Management</title>
<meta name=viewport content="width=device-width, initial-scale=1">
<link href="style.css" rel="stylesheet">
<meta name="mobile-web-app-capable" content="yes">
<link rel="apple-touch-icon" sizes="180x180" href="//<?=getenv('HOST');?>/management-icon.png" />
<script src=moment.min.js></script>
<script src=main.js></script>
</head>
<body>

<?php
include("guardlogs.php");
include("homeownerlogs.php");
//include("wwwlogs.php");
?>

<footer><a href=https://github.com/kaihendry/myresponder>MIT licensed source code</a> version <?php echo getenv("COMMIT"); ?> </footer>
</body>
</html>
