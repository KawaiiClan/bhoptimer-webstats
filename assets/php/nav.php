<div class="sidenav">
	<center>
	<h1><?=TOPLEFT_TITLE?></h1>
	<br><br>
	<hr>
	<a href="<?=SERVER_IP?>">Join Server</a>
	<hr>
	<a href="index.php">Top Players</a>
	<a href="index.php?rr=1">Recent Records</a>
	<a href="index.php?rt=1">Recent Times</a>
	<hr>
	<br>
	Go to map:
	<br><br>
	<form action="index.php" method="GET">
		<select style="max-width: 80%;" name="m" class="form-control" onchange="this.form.submit()" required>
			<option value="" selected="selected">None</option>
<?php
			$result = mysqli_query($connection, 'SELECT DISTINCT map FROM '.MYSQL_PREFIX.'mapzones ORDER BY map ASC;');
			if($result->num_rows > 0)
			{
				while ($row = $result->fetch_assoc())
				{
?>
					<option value="<?=$row['map']?>"<?php echo ($row['map'] == $m)?' selected="selected"':'';?>><?=$row['map']?></option>
<?php
				}
			}
?>
		</select>
	</form>
	<br>
	<hr>
	<br>
	Find a player:
	<br>
	(SteamID or Username)
	<br><br>
	<form id="search" method="GET">
		<input type="text" name="u" aria-label="..." placeholder="SteamID or Username" value="<?=(isset($u))?$u:''?>"/>
			<button type="submit" class="btn btn-primary">Search</button>
	</form>
	<br>
	<hr>
	<a href="<?=HOME_SITE?>">Home Site</a>
	</center>
</div>
