<h3>Active responders</h3>

<ol>
<?php
foreach (glob("../g/r/*.json") as $responder) {
	echo "<li>" . display($responder) . "</li>";
}
?>
</ol>

<p>Total shifts: <?php echo `find ../g -mindepth 3 -name '*.json' | wc -l`;?></p>

<h3>Past shifts of responders</h3>
<ol>
<?php
$items = glob('../g/r/*/*.json', GLOB_NOSORT);
array_multisort(array_map('filemtime', $items), SORT_NUMERIC, SORT_DESC, $items);
foreach ($items as $fn) {
	$wfn = substr($fn, 5);
	echo "<li><a href=//g.uptown.dabase.com/" . $wfn . ">";
	echo  basename($fn) . " log size " . filesize($fn) . ", last modified " . date("c", filemtime($fn));
	echo "</a></li>\n";
}
?>
</ol>
