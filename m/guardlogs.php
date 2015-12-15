<?php
require_once("../config.php");

?>

<table class=persons>
<caption>Responders</caption>
<thead>
<tr>
<th>Arm</th>
<th>Registered</th>
<th>Name</th>
<th>Telephone</th>
<th>Login as</th>
</tr>
</thead>
<tbody>

<?php
foreach (glob("../g/r/*.json") as $rfn) {
	$r = json_decode(file_get_contents($rfn), true);
	$id = $r["ic"];
?>
<tr>
<td><input id="<?=$id?>" <?php echo (file_exists("arm/$id") ? "checked" : ""); ?> type=checkbox><label for="<?=$id?>">&nbsp;</label></td>
<td><?php echo "<a href=//g.$HOST/". substr($rfn, 5) . "><time datetime=" . date("c", $r['intime']) . ">" . date("c", $r['intime']) . "</time>"; ?></a></td>
<td><?=$r['name']?></td>
<td><a href=tel:<?=$r['tel']?>><?=$r['tel']?></a></td>
<td><a style="text-decoration:none;" href="http://g.<?=$HOST?>/clockin.php?<?php echo htmlspecialchars(http_build_query(array("ic" => $r["ic"], "tel" => $r["tel"], "name" => $r["name"] ))); ?>">💂</a></td>
</tr>


<?php
	// echo "<li><a href=//g.$HOST/". substr($responder,5) . ">" . basename($responder) . "</a></li>";
}
?>

</tbody>
</table>
