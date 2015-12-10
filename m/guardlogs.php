<?php
require_once("../config.php");

?>

<table>
<caption>Responders</caption>
<thead>
<tr>
<th>Last seen</th>
<th>Name</th>
<th>Telephone</th>
</tr>
</thead>
<tbody>

<?php
foreach (glob("../g/r/*.json") as $rfn) {
	$r = json_decode(file_get_contents($rfn), true);
?>
<tr>
<td><?php echo "<a href=//g.$HOST/". substr($rfn, 5) . "><time datetime=" . date("c", $r['intime']) . ">" . date("c", $r['intime']) . "</time>"; ?></a></td>
<td><?=$r['name']?></td>
<td><a href=tel:<?=$r['tel']?>><?=$r['tel']?></a></td>
</tr>


<?php
	// echo "<li><a href=//g.$HOST/". substr($responder,5) . ">" . basename($responder) . "</a></li>";
}
?>

</tbody>
</table>
