<?php

/* @var $this yii\web\View */

$this->title = 'info';
//$this->params['breadcrumbs'][] = $this->title;
?>


<div class="container">
	<?php if (isset($Exception)): ?>
		<div class="panel panel-primary">
			<div class="panel-heading"><?php echo Get_Class($Exception); ?> at
				line <?php echo $Exception->getLine(); ?></div>
			<p><b><?php echo htmlspecialchars($Exception->getMessage()); ?></b></p>
			<p><?php echo nl2br($e->getTraceAsString(), false); ?></p>
		</div>
	<?php else: ?>
		<div class="row">
			<div class="col-sm-6">
				<table class="table table-bordered table-striped">
					<thead>
					<tr>
						<th class="info-column">Server Info</th>
						<th><span
								class="label label-<?php echo $Timer > 1.0 ? 'danger' : 'success'; ?>"><?php echo $Timer; ?>s</span>
						</th>
					</tr>
					</thead>
					<tbody>
					<?php if (Is_Array($Info)): ?>
						<?php foreach ($Info as $InfoKey => $InfoValue): ?>
							<tr>
								<td><?php echo htmlspecialchars($InfoKey); ?></td>
								<td><?php
									if (Is_Array($InfoValue)) {
										echo "<pre>";
										print_r($InfoValue);
										echo "</pre>";
									} else {
										if ($InfoValue === true) {
											echo 'true';
										} else if ($InfoValue === false) {
											echo 'false';
										} else {
											echo htmlspecialchars($InfoValue);
										}
									}
									?></td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="2">No information received</td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
			<div class="col-sm-6">
				<table class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>Player <span class="label label-info"><?php echo count($Players); ?></span></th>
						<th class="frags-column">Frags</th>
						<th class="frags-column">Time</th>
					</tr>
					</thead>
					<tbody>
					<?php if (!empty($Players)): ?>
						<?php foreach ($Players as $Player): ?>
							<tr>
								<td><?php echo htmlspecialchars($Player['Name']); ?></td>
								<td><?php echo $Player['Frags']; ?></td>
								<td><?php echo $Player['TimeF']; ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="3">No players received</td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-bordered table-striped">
					<thead>
					<tr>
						<th colspan="2">Rules <span class="label label-info"><?php echo count($Rules); ?></span></th>
					</tr>
					</thead>
					<tbody>
					<?php if (Is_Array($Rules)): ?>
						<?php foreach ($Rules as $Rule => $Value): ?>
							<tr>
								<td><?php echo htmlspecialchars($Rule); ?></td>
								<td><?php echo htmlspecialchars($Value); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="2">No rules received</td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php endif; ?>
</div>