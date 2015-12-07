<?php
include("../h/common.php");
?>

<p>Total records of incidents: <?php echo `find ../h -mindepth 3 -name '*.json' | wc -l`;?></p>

<h3>Log of events</h3>
<ol>
<?php
$items = glob('../h/r/*/*.json', GLOB_NOSORT);
array_multisort(array_map('filemtime', $items), SORT_NUMERIC, SORT_DESC, $items);
foreach ($items as $fn) {
	$wfn = substr($fn, 5);
	echo "<li><a href=//h.uptown.dabase.com/" . $wfn . ">";
	echo  basename($fn) . " log size " . filesize($fn) . ", last modified " . date("c", filemtime($fn));
	echo "</a></li>\n";
}
?>
</ol>

<h3>Registered home owners with alarms enabled</h3>

<ol>
<?php
foreach (glob("../h/r/*.json") as $responder) {
	echo "<li>" . display($responder) . "</li>";
}
?>
</ol>


