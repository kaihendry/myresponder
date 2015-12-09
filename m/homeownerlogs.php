<?php
require_once("../config.php");

$alerts = glob("../h/r/*/alert/*.json");
rsort($alerts);
?>

<h3>Log of alerts</h3>
<ol>
<?php
foreach ($alerts as $aj) {
	echo "<li><a href=//h.$HOST/r/" . substr($aj, 7) . ">" . date("r", basename($aj, ".json")) . "</a>";
	echo "</li>";
}
?>
</ol>

<h3>Registered home owners</h3>

<ol>
<?php
foreach (glob("../h/r/*.json") as $hoj) {
	$ho = json_decode(file_get_contents($hoj), true);
	echo "<li><a href=//h.$HOST/r/" . basename($hoj) . ">" . date("r", $ho["intime"]) . "</a> " . $ho["name"];
	if (file_exists("../h/muted/" . $ho["ic"])) {
		echo "MUTED";
	} else {
		echo "ACTIVE";
	}
	echo "</li>";
}
?>
</ol>
