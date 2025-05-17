<?php $img = (file_exists(MAP_SC_DIR.$m.'.jpg')) ? MAP_SC_DIR.$m.'.jpg' : (file_exists(MAP_SC_DIR.$m.'.png') ? MAP_SC_DIR.$m.'.png' : MAP_SC_DIR.'nomap.jpg');

$stmt = false;
$stmt = $connection->prepare('SELECT tier FROM '.MYSQL_PREFIX.'maptiers WHERE map = "'.$m.'";');
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($tier);
while($stmt->fetch())
{
	$tier = $tier;
}
?>
<p><h1><?=$m?></h1></p>
<p><h2>Tier <?=$tier?></h2></p>
<img src="<?=$img?>"/>
<br><br>
<?php
$t = isset($_REQUEST['t']) ? (int)$_REQUEST['t'] : DEFAULT_TRACK;
$s = isset($_REQUEST['s']) ? (int)$_REQUEST['s'] : DEFAULT_STYLE;

switch($f)
{
	case 0:
		$filter = ' ORDER BY points DESC ';
		break;
	
	case 1:
		$filter = ' ORDER BY points ASC ';
		break;
	
	case 2:
		$filter = ' ORDER BY date DESC ';
		break;
	
	case 3:
		$filter = ' ORDER BY date ASC ';
		break;
		
	case 4:
		$filter = ' ORDER BY time ASC ';
		break;
	
	case 5:
		$filter = ' ORDER BY time DESC ';
		break;
	
	default:
		$filter = '';
		break;
}

$results = false;
$stmt = false;
if($s == -1 && $t == -1)
{
	$stmt = $connection->prepare('SELECT u.auth, u.name, pt.time, pt.jumps, pt.strafes, pt.sync, pt.date, pt.points, pt.style, pt.track FROM '.MYSQL_PREFIX.'playertimes pt JOIN '.MYSQL_PREFIX.'users u ON pt.auth = u.auth WHERE pt.map = "'.$m.'"'.$filter.';');
}
elseif($t == -1)
{
	$stmt = $connection->prepare('SELECT u.auth, u.name, pt.time, pt.jumps, pt.strafes, pt.sync, pt.date, pt.points, pt.style, pt.track FROM '.MYSQL_PREFIX.'playertimes pt JOIN '.MYSQL_PREFIX.'users u ON pt.auth = u.auth WHERE pt.map = "'.$m.'" AND pt.style = '.$s.$filter.';');
}
elseif($s == -1)
{
	$stmt = $connection->prepare('SELECT u.auth, u.name, pt.time, pt.jumps, pt.strafes, pt.sync, pt.date, pt.points, pt.style, pt.track FROM '.MYSQL_PREFIX.'playertimes pt JOIN '.MYSQL_PREFIX.'users u ON pt.auth = u.auth WHERE pt.map = "'.$m.'" AND pt.track = '.$t.$filter.';');
}
else
{
	$stmt = $connection->prepare('SELECT u.auth, u.name, pt.time, pt.jumps, pt.strafes, pt.sync, pt.date, pt.points, pt.style, pt.track FROM '.MYSQL_PREFIX.'playertimes pt JOIN '.MYSQL_PREFIX.'users u ON pt.auth = u.auth WHERE pt.map = "'.$m.'" AND pt.style = '.$s.' AND pt.track = '.$t.$filter.';');
}
$stmt->execute();
$stmt->store_result();
$results = ($rows = $stmt->num_rows) > 0;
$stmt->bind_result($auth, $name, $time, $jumps, $strafes, $sync, $date, $points, $style, $track);

include('assets/php/ts-bar.php');
echo ' Times: '.number_format($rows).'<br><br>';
include('assets/php/filter-bar.php');

if($rows > 0)
{
	$first = true;
	$rank = 1;
	while($row = $stmt->fetch())
	{
		if($first)
		{
			$first = false;
?>
			<table>
				<thead>
					<th>Rank</th>
					<th></th>
					<th>Name</th>
					<?=($t==-1)?'<th>Track</th>':''?>
					<?=($s==-1)?'<th>Style</th>':''?>
					<th>Time</th>
					<th>Jumps</th>
					<th>Strafes</th>
					<th>Sync</th>
					<th>Points</th>
					<th>Date</th>
				</thead>
<?php
		}
?>
				<tr>
					<td><?='#'.$rank?></td>
					<td>
<?php
					$steamid = SteamID::Parse($auth, SteamID::FORMAT_S32);
					$steamid64 = $steamid->Format(SteamID::FORMAT_STEAMID64);
					echo '<a href="https://steamcommunity.com/profiles/'.$steamid64.'/" target="_blank"><img src="assets/img/steam-icon.png"></img></a>';
?>
					</td>
					<td><?='<a href="index.php?sv='.$sv.'&u='.$steamid64.'">'.$name.'</a>'?></td>
					<?=($t==-1)?'<td>'.$tracks[$track].'</td>':''?>
					<?=($s==-1)?'<td>'.$styles[$style].'</td>':''?>
					<td><?=formattoseconds($time)?></td>
					<td><?=$jumps?></td>
					<td><?=$strafes?></td>
					<td><?=number_format($sync, 2)?>%</td>
					<td><?=number_format($points, 2)?></td>
					<td><?=date('j M Y', $date)?></td>
				</tr>
<?php
		if(++$rank > RECORD_LIMIT)
		{
			break;
		}
	}
?>
			</table>
<?php
}
else
{
	echo '<h1>No times</h1>';
}
if($stmt != false)
{
	$stmt->close();
}
$connection->close();
if(!$results)
{
	echo '<h1>No times yet</h1> <br />';
}
?>
