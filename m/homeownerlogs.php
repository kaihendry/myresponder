<?php
require_once("../config.php");

$alerts = glob("../h/r/*/alert/*.json");
rsort($alerts);
?>

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

<h3>Log of alerts</h3>
<ol>
<?php
foreach ($alerts as $aj) {
	$a = json_decode(file_get_contents($aj), true);
	echo "<li><a href=//h.$HOST/r/" . substr($aj, 7) . ">" . date("r", basename($aj, ".json")) . "</a>";
	echo ($a["raiser"]["name"] . " " . $a["raiser"]["address"] . " " . $a["raiser"]["tel"]);
	echo "</li>";
}
?>
</ol>


