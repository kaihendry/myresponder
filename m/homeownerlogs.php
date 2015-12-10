<?php
require_once("../config.php");

$alerts = glob("../h/r/*/alert/*.json");
rsort($alerts);
?>

<table>
<caption>Registered home owners</caption>
<thead>
<tr>
<th>Last seen</th>
<th>Name</th>
<th>Telephone</th>
<th></th>
</tr>
</thead>
<tbody>

<?php
foreach (glob("../h/r/*.json") as $hoj) {
	$ho = json_decode(file_get_contents($hoj), true);
?>
<tr>
<td><?php echo "<a href=//h.$HOST/r/" . basename($hoj) . ">" . date("c", $ho["intime"]); ?></a></td>
<td><?=$ho['name']?></td>
<td><a href=tel:<?=$ho['tel']?>><?=$ho['tel']?></a></td>
<td><button data-id=<?=$ho['ic']?>><?php echo (file_exists("../h/muted/" . $ho["ic"]) ? 'Unmute' : 'Mute') . "</button>";?></td>
</tr>
<?php
}
?>

</tbody>
</table>

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


