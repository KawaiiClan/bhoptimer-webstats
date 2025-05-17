<?php
$results = false;
$stmt = false;
$stmt = $connection->prepare('SELECT auth, name, lastlogin, points FROM '.MYSQL_PREFIX.'users ORDER BY points DESC LIMIT '.PLAYER_TOP_RANKING_LIMIT.' OFFSET 0;');
$stmt->execute();
$stmt->store_result();
$results = ($rows = $stmt->num_rows) > 0;
$stmt->bind_result($auth, $name, $lastlogin, $points);

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
			<p><h1>Top <?php echo PLAYER_TOP_RANKING_LIMIT; ?> Players</h1></p>

			<table>
				<thead>
					<th>Rank</th>
					<th>Name</th>
					<th></th>
					<th>Points</th>
					<th>Last Seen</th>
				</thead>

<?php
		}
		$steamid = SteamID::Parse($auth, SteamID::FORMAT_S32);
		$steamid64 = $steamid->Format(SteamID::FORMAT_STEAMID64);
?>
				<tr>
					<td><?='#'.$rank?></td>
					<td><?='<a href="index.php?u='.$steamid64.'">'.$name.'</a>'; ?></td>
					<td><center>
						<?='<a href="https://steamcommunity.com/profiles/'.$steamid64.'/" target="_blank"><img src="assets/img/steam-icon.png"></img></a>'?>
					</center></td>
					<td><?=$points; ?></td>
					<td><?=($lastlogin>0)?date('j M Y', $lastlogin):'Unknown'?></td>
				</tr>
<?php
		if (++$rank > PLAYER_TOP_RANKING_LIMIT)
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
	echo '<h1>No ranked players yet</h1> <br />';
}
if($stmt != false)
{
	$stmt->close();
}
$connection->close();
?>
