<h3>Web logs</h3>
<?php

// /var/log/php-fpm/www-error.log
//

echo "<ul id=wwwlogs>\n";
$d = array("g", "h", "m");
$b = dirname (dirname ( __FILE__ ));
foreach ($d as $value) {
	foreach (glob("$b/$value/l/*.log") as $filename) {
		if (filesize($filename) > 0) {
		echo "<li><a href=//$value.uptown.dabase.com/l/" . basename($filename) . ">";
		echo "$value/" . basename($filename) . " log size " . filesize($filename) . ", last modified " . date("c", filemtime($filename));
		echo "</a></li>\n";
		}
	}
}
echo "</ul>";


?>
