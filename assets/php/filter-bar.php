<form action="index.php" method="GET">
	<?=($rt)?'<input type="hidden" name="rt" id="rt" value="1"/>':''?>
	<?=($rr)?'<input type="hidden" name="rr" id="rr" value="1"/>':''?>
	<?=(isset($u))?'<input type="hidden" name="u" id="u" value="'.$u.'"/>':''?>
	<?=(isset($m))?'<input type="hidden" name="m" id="m" value="'.$m.'"/>':''?>
	<?='<input type="hidden" name="t" id="t" value="'.$t.'"/>'?>
	<?='<input type="hidden" name="s" id="s" value="'.$s.'"/>'?>
	<select name="f" id="f" onchange="this.form.submit()">
<?php
	foreach($filters as $id=>$filter)
	{
?>
		<option value="<?=$id?>"<?php echo($id == $f)?' selected="selected"':''?>><?=$filter?></option>
<?php
	}
?>
	</select>
</form>
