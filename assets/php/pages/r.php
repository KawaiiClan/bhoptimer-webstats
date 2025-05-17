<?php
$results = false;
$stmt = false;
//i could have done this a number of different ways, but none really save lines, so verbosity it is. might tweak later, but it works
if($rt)
{
	if($s == -1 && $t == -1)
	{
		$stmt = $connection->prepare('SELECT p.map, u.name, p.style, p.time, p.jumps, p.strafes, p.sync, u.auth, p.date, p.points, p.track FROM '.MYSQL_PREFIX.'playertimes p JOIN '.MYSQL_PREFIX.'users u ON p.auth = u.auth ORDER BY date DESC LIMIT '.RECORD_LIMIT_LATEST.' OFFSET 0;');
	}
	elseif($t == -1)
	{
		$stmt = $connection->prepare('SELECT p.map, u.name, p.style, p.time, p.jumps, p.strafes, p.sync, u.auth, p.date, p.points, p.track FROM '.MYSQL_PREFIX.'playertimes p JOIN '.MYSQL_PREFIX.'users u ON p.auth = u.auth AND p.style = '.$s.' ORDER BY date DESC LIMIT '.RECORD_LIMIT_LATEST.' OFFSET 0;');
	}
	elseif($s == -1)
	{
		$stmt = $connection->prepare('SELECT p.map, u.name, p.style, p.time, p.jumps, p.strafes, p.sync, u.auth, p.date, p.points, p.track FROM '.MYSQL_PREFIX.'playertimes p JOIN '.MYSQL_PREFIX.'users u ON p.auth = u.auth AND p.track = '.$t.' ORDER BY date DESC LIMIT '.RECORD_LIMIT_LATEST.' OFFSET 0;');
	}
	else
	{
		$stmt = $connection->prepare('SELECT p.map, u.name, p.style, p.time, p.jumps, p.strafes, p.sync, u.auth, p.date, p.points, p.track FROM '.MYSQL_PREFIX.'playertimes p JOIN '.MYSQL_PREFIX.'users u ON p.auth = u.auth AND p.style = '.$s.' AND p.track = '.$t.' ORDER BY date DESC LIMIT '.RECORD_LIMIT_LATEST.' OFFSET 0;');
	}
}
elseif($rr)
{
	if($s == -1 && $t == -1)
	{
		$stmt = $connection->prepare('SELECT p.map, u.name, p.style, p.time, p.jumps, p.strafes, p.sync, u.auth, p.date, p.points, p.track FROM '.MYSQL_PREFIX.'playertimes p JOIN (SELECT MIN(time) time, map, style, track FROM '.MYSQL_PREFIX.'playertimes GROUP by map, style, track) t JOIN '.MYSQL_PREFIX.'users u ON p.time = t.time AND p.auth = u.auth AND p.map = t.map AND p.style = t.style AND p.track = t.track ORDER BY date DESC LIMIT '.RECORD_LIMIT_LATEST.' OFFSET 0;');
	}
	elseif($t == -1)
	{
		$stmt = $connection->prepare('SELECT p.map, u.name, p.style, p.time, p.jumps, p.strafes, p.sync, u.auth, p.date, p.points, p.track FROM '.MYSQL_PREFIX.'playertimes p JOIN (SELECT MIN(time) time, map, style, track FROM '.MYSQL_PREFIX.'playertimes GROUP by map, style, track) t JOIN '.MYSQL_PREFIX.'users u ON p.time = t.time AND p.auth = u.auth AND p.map = t.map AND p.style = '.$s.' AND p.track = t.track ORDER BY date DESC LIMIT '.RECORD_LIMIT_LATEST.' OFFSET 0;');
	}
	elseif($s == -1)
	{
		$stmt = $connection->prepare('SELECT p.map, u.name, p.style, p.time, p.jumps, p.strafes, p.sync, u.auth, p.date, p.points, p.track FROM '.MYSQL_PREFIX.'playertimes p JOIN (SELECT MIN(time) time, map, style, track FROM '.MYSQL_PREFIX.'playertimes GROUP by map, style, track) t JOIN '.MYSQL_PREFIX.'users u ON p.time = t.time AND p.auth = u.auth AND p.map = t.map AND p.style = t.style AND p.track = '.$t.' ORDER BY date DESC LIMIT '.RECORD_LIMIT_LATEST.' OFFSET 0;');
	}
	else
	{
		$stmt = $connection->prepare('SELECT p.map, u.name, p.style, p.time, p.jumps, p.strafes, p.sync, u.auth, p.date, p.points, p.track FROM '.MYSQL_PREFIX.'playertimes p JOIN (SELECT MIN(time) time, map, style, track FROM '.MYSQL_PREFIX.'playertimes GROUP by map, style, track) t JOIN '.MYSQL_PREFIX.'users u ON p.time = t.time AND p.auth = u.auth AND p.map = t.map AND p.style = '.$s.' AND p.track = '.$t.' ORDER BY date DESC LIMIT '.RECORD_LIMIT_LATEST.' OFFSET 0;');
	}
	
}
echo $connection->error;

$stmt->execute();
$stmt->store_result();
$results = ($rows = $stmt->num_rows) > 0;
$stmt->bind_result($map, $name, $style, $time, $jumps, $strafes, $sync, $auth, $date, $points, $track);
?>
<p><h1>Recent <?=$rt?'Times':'Records'?></h1></p>
<?php
include('assets/php/ts-bar.php');
if($rows > 0)
{
	$records = 0;
	$first = true;

	while($row = $stmt->fetch())
	{
		if($first)
		{
?>
			<table>
				<thead>
					<th></th>
					<th>Name</th>
					<th>Map</th>
					<th>Track</th>
					<th>Style</th>
					<th>Time</th>
					<th>Jumps</th>
					<th>Strafes</th>
					<th>Sync</th>
					<th>Points</th>
					<th>Date</th>
				</thead>
<?php
			$first = false;
		}
?>
				<tr>
					<td><center>
<?php
						$steamid = SteamID::Parse($auth, SteamID::FORMAT_S32);
						$steamid64 = $steamid->Format(SteamID::FORMAT_STEAMID64);
						echo '<a href="https://steamcommunity.com/profiles/'.$steamid64.'/" target="_blank"><img src="assets/img/steam-icon.png"></img></a>';
?>
					</center></td>
					<td><?='<a href="index.php?u='.$steamid64.'">'.$name.'</a>'?></td>
					<td><?='<a href="index.php?m='.$map.'">'.$map.'</a>'?></td>
					<td><?=$tracks[$track]?></td>
					<td><?=$styles[$style]?></td>
					<td><?=formattoseconds($time)?></td>
					<td><?=$jumps?></td>
					<td><?=$strafes?></td>
					<td><?=number_format($sync, 2)?>%</td>
					<td><?=number_format($points, 2)?></td>
					<td><?=date('j M Y', $date)?></td>
				</tr>
<?php
		if(++$records > RECORD_LIMIT_LATEST)
		{
			break;
		}
	}
?>
			</table>
<?php
}
if($stmt != false)
{
	$stmt->close();
}
$connection->close();
if (!$results)
{
	echo '<h1>No times yet</h1> <br />';
}
?>
