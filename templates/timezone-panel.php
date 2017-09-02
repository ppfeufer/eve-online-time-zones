<?php
$panelType = 'default';
if(isset($panel)) {
	$panelType = $panel;
}
?>

<div class="col-sm-6 col-md-4 col-lg-3">
	<div class="panel panel-<?php echo $panelType; ?>">
		<div class="panel-heading">
			<h3 class="panel-title">
				<?php echo $title; ?> <span class="pull-right"><i id="icon-<?php echo $tzCode; ?>"></i></span>
			</h3>
		</div>

		<div class="panel-body text-center">
			<b id="time-<?php echo $tzCode; ?>" style="font-size:140%;">--:--:--</b><br>
			<span id="date-<?php echo $tzCode; ?>">(loading)</span>
		</div>
	</div>
</div>
