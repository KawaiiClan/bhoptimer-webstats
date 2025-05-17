<form action="index.php" method="GET" style=" display:inline!important;">
	<?=($rt)?'<input type="hidden" name="rt" id="rt" value="1"/>':''?>
	<?=($rr)?'<input type="hidden" name="rr" id="rr" value="1"/>':''?>
	<?=(isset($u))?'<input type="hidden" name="u" id="u" value="'.$u.'"/>':''?>
	<?=(isset($m))?'<input type="hidden" name="m" id="m" value="'.$m.'"/>':''?>
	<?=($f>0)?'<input type="hidden" name="f" id="f" value="'.$f.'"/>':''?>
	<?='<input type="hidden" name="s" id="s" value="'.$s.'"/>'?>
	<select name="t" id="t" onchange="this.form.submit()">
<?php
	foreach($tracks as $id=>$track)
	{
?>
		<option value="<?=$id?>"<?php echo($id == $t)?' selected="selected"':''?>><?=$track?></option>
<?php
	}
?>
	</select>
</form>

<form action="index.php" method="GET" style="display:inline!important;">
	<?=($rt)?'<input type="hidden" name="rt" id="rt" value="1"/>':''?>
	<?=($rr)?'<input type="hidden" name="rr" id="rr" value="1"/>':''?>
	<?=(isset($u))?'<input type="hidden" name="u" id="u" value="'.$u.'"/>':''?>
	<?=(isset($m))?'<input type="hidden" name="m" id="m" value="'.$m.'"/>':''?>
	<?=($f>0)?'<input type="hidden" name="f" id="f" value="'.$f.'"/>':''?>
	<?='<input type="hidden" name="t" id="t" value="'.$t.'"/>'?>
	<select name="s" id="s" onchange="this.form.submit()">
<?php
	foreach($styles as $id=>$style)
	{
?>
		<option value="<?=$id?>"<?php echo($id == $s)?' selected="selected"':''?>><?=$style?></option>
<?php
	}
?>
	</select>
</form>
