<?php
require_once("../config.php");

$alerts = glob("../h/r/*/alert/*.json");
rsort($alerts);
?>

<table>
<caption>Registered home owners</caption>
<thead>
<tr>
<th>Time</th>
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
<td>
<?php
$ft = date("c", $ho["intime"]);
echo "<a href=//h.$HOST/r/" . basename($hoj) . "><time datetime=$ft>$ft</time></a>"; ?>
</td>
<td><?=$ho['name']?></td>
<td><a href=tel:<?=$ho['tel']?>><?=$ho['tel']?></a></td>
<td><button data-id=<?=$ho['ic']?>><?php echo (file_exists("../h/muted/" . $ho["ic"]) ? 'Unmute' : 'Mute') . "</button>";?></td>
</tr>
<?php
}
?>

</tbody>
</table>

<table>
<caption>Incidents</caption>
<thead>
<tr>
<th>Time</th>
<th>Name</th>
<th>Address</th>
<th>Telephone</th>
</tr>
</thead>
<tbody>



<?php
foreach ($alerts as $aj) {
	$a = json_decode(file_get_contents($aj), true);
?>
<tr <?php echo ((empty($a["guards"][0]["result"]) ? "class=muted" : "")); ?>>
<td>
<?php
$ft = date("c", basename($aj, ".json"));
echo "<a href=//h.$HOST/r/" . substr($aj, 7) . "><time datetime=$ft>$ft</time></a>"; ?>
</td>
<td><?=$a["raiser"]["name"]?></td>
<td><?=$a["raiser"]["address"]?></td>
<td><a href=tel:<?=$a["raiser"]["tel"]?>><?=$a["raiser"]["tel"]?></a></td>
</tr>
<?php
}
?>
</tbody>
</table>


