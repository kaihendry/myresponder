<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Management</title>
<meta name=viewport content="width=device-width, initial-scale=1">
<link href="http://uptown.dabase.com/style.css" rel="stylesheet">
</head>
<body>

<table>
<caption>Incidents</caption>
<thead>
<tr>
<th>Id</th>
<th>Time</th>
<th>Address</th>
<th>Text log</th>
</tr>
</thead>
<tbody>

<tr class=active>
<td><a href=#details>6</a></td>
<td id=t>50s</td>
<td>#3 SS 22/11</td>
<td id=logupdate></td>
</tr>

<tr >
<td><a href=#details>5</a></td>
<td>4m2s</td>
<td>#13 SS 22/12</td>
<td><span title="time" class=ho>Noise outside.</span> <span class=mgmt>Checked by Mr Green. Nothing found. Mrs Soso agitated.</span></td>
</tr>

<tr>
<td><a href=#details>4</a></td>
<td>2m30s</td>
<td>#11 SS 22/12</td>
<td><span class=ho>Suspicious character with cap.</span><span class=mgmt>Observed exit through Gate B.</td>
</tr>

</tbody>
</table>

<?php
include("guardlogs.php");
include("homeownerlogs.php");
//include("wwwlogs.php");
?>

</body>
</html>
