<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Management</title>
<meta name=viewport content="width=device-width, initial-scale=1">
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

<table>
<caption>Security on Duty</caption>
<thead>
<tr>
<th>Last seen</th>
<th>Name</th>
<th>Notification method</th>
</tr>
</thead>
<tbody>

<tr>
<td>4hr5m</td>
<td>Mr Green</td>
<td><a href=#log>030-667563</a></td>
</tr>

<tr>
<td>5hr55m</td>
<td>Mr Mustard</td>
<td><a href=#log>030-123563</a></td>
</tr>

<tr>
<td>6hr5m</td>
<td>Mr Black</td>
<td><a href=#log>Pushover</a></td>
</tr>

<tr class=inactive>
<td>Logged out 2015-11-29 5PM (8hr2m shift)</td>
<td>Mr Brown</td>
<td><a href=#log>030-343456</a></td>
</tr>

<tr class=inactive>
<td>Timed out 2015-11-29 5PM (7hr2m shift)</td>
<td>Mr Pink</td>
<td><a href=#log>03-2314235</a></td>
</tr>


</tbody>
</table>


<?php
include("homeownerlogs.php");
include("guardlogs.php");
include("wwwlogs.php");
?>

</body>
</html>
