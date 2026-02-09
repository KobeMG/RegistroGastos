<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
	<div>
		<h2 class="mb-0"><i class="fa-solid fa-chart-line text-primary"></i> Dashboard Financiero</h2>
		<?php if (isset($usuario) && $usuario): ?>
			<small class="text-muted">Bienvenido, <?= esc($usuario['nombre']) ?></small>
		<?php endif; ?>
	</div>
	<div>
		<a href="<?= base_url('cierres') ?>" class="btn btn-outline-primary">
			<i class="fa-solid fa-calendar-check"></i> Ir a Cierres
		</a>
	</div>
</div>

<!-- Actividad reciente -->
<div class="card shadow-sm mt-4 mb-4">
	<div class="card-header bg-white">
		<strong><i class="fa-solid fa-clock-rotate-left"></i> Actividad reciente</strong>
	</div>
	<div class="card-body">
		<?php
		$actividadReciente = [];
		$gastosRecientes = $gastosRecientes ?? [];
		$ingresosRecientes = $ingresosRecientes ?? [];

		foreach ($gastosRecientes as $gasto) {
			$actividadReciente[] = [
				'tipo' => 'gasto',
				'fecha' => $gasto['fecha_gasto'],
				'descripcion' => $gasto['descripcion'] ?? 'Sin descripción',
				'categoria' => $gasto['categoria_nombre'] ?? 'Sin categoría',
				'monto' => $gasto['monto'],
			];
		}

		foreach ($ingresosRecientes as $ingreso) {
			$actividadReciente[] = [
				'tipo' => 'ingreso',
				'fecha' => $ingreso['fecha_ingreso'],
				'descripcion' => $ingreso['descripcion'] ?? 'Sin descripción',
				'categoria' => ucfirst($ingreso['tipo'] ?? 'Ingreso'),
				'monto' => $ingreso['monto'],
			];
		}

		usort($actividadReciente, function ($a, $b) {
			return strtotime($b['fecha']) <=> strtotime($a['fecha']);
		});

		$actividadReciente = array_slice($actividadReciente, 0, 15);
		?>

		<?php if (!empty($actividadReciente)): ?>
			<div class="list-group list-group-flush">
				<?php foreach ($actividadReciente as $item): ?>
					<div class="list-group-item px-0">
						<div class="d-flex w-100 justify-content-between align-items-center">
							<div class="d-flex align-items-center flex-grow-1">
								<div class="me-3">
									<?php if ($item['tipo'] === 'gasto'): ?>
										<div class="bg-danger bg-opacity-10 rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
											<i class="fa-solid fa-arrow-up text-danger"></i>
										</div>
									<?php else: ?>
										<div class="bg-success bg-opacity-10 rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
											<i class="fa-solid fa-arrow-down text-success"></i>
										</div>
									<?php endif; ?>
								</div>
								<div class="flex-grow-1">
									<div class="fw-semibold"><?= esc($item['descripcion']) ?></div>
									<small class="text-muted">
										<i class="fa-solid fa-tag"></i> <?= esc($item['categoria']) ?> ·
										<i class="fa-solid fa-calendar"></i> <?= date('d/m/Y', strtotime($item['fecha'])) ?>
									</small>
								</div>
							</div>
							<div class="text-end ms-3">
								<div class="fw-bold <?= $item['tipo'] === 'gasto' ? 'text-danger' : 'text-success' ?>">
									<?= $item['tipo'] === 'gasto' ? '-' : '+' ?>₡ <?= number_format($item['monto'], 2, ',', '.') ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<div class="text-center text-muted py-4">
				<i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i>
				<p class="mb-0">No hay actividad reciente</p>
			</div>
		<?php endif; ?>
	</div>
</div>


<!-- Resumen de métricas -->
<div class="row g-3 mb-4">
	<div class="col-12 col-md-6 col-lg-3">
		<div class="card shadow-sm h-100">
			<div class="card-body">
				<div class="d-flex align-items-center justify-content-between">
					<div>
						<div class="text-muted">Ingresos Totales</div>
						<div class="h4 mb-0">₡ <?= number_format((float)($totalIngresos ?? 0), 2, ',', '.') ?></div>
					</div>
					<div class="ms-3 text-success"><i class="fa-solid fa-arrow-trend-up fa-2x"></i></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-lg-3">
		<div class="card shadow-sm h-100">
			<div class="card-body">
				<div class="d-flex align-items-center justify-content-between">
					<div>
						<div class="text-muted">Gastos Totales</div>
						<div class="h4 mb-0">₡ <?= number_format((float)($totalGastos ?? 0), 2, ',', '.') ?></div>
					</div>
					<div class="ms-3 text-danger"><i class="fa-solid fa-arrow-trend-down fa-2x"></i></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-lg-3">
		<?php
		$balanceVal = (float)($balance ?? 0);
		$balanceClass = $balanceVal >= 0 ? 'text-success' : 'text-danger';
		$balanceIcon  = $balanceVal >= 0 ? 'fa-circle-check' : 'fa-circle-exclamation';
		?>
		<div class="card shadow-sm h-100">
			<div class="card-body">
				<div class="d-flex align-items-center justify-content-between">
					<div>
						<div class="text-muted">Balance</div>
						<div class="h4 mb-0 <?= $balanceClass ?>">₡ <?= number_format($balanceVal, 2, ',', '.') ?></div>
					</div>
					<div class="ms-3 <?= $balanceClass ?>"><i class="fa-solid <?= $balanceIcon ?> fa-2x"></i></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-lg-3">
		<?php
		$ord = (float)($totalOrdinarios ?? 0);
		$ext = (float)($totalExtraordinarios ?? 0);
		$sum = ($ord + $ext);
		$pOrd = $sum > 0 ? round(($ord / $sum) * 100) : 0;
		$pExt = $sum > 0 ? round(($ext / $sum) * 100) : 0;
		?>
		<div class="card shadow-sm h-100">
			<div class="card-body">
				<div class="text-muted mb-2">Ingresos por tipo</div>
				<div class="d-flex justify-content-between mb-1">
					<span>Ordinarios</span>
					<span class="fw-semibold">₡ <?= number_format($ord, 2, ',', '.') ?> (<?= $pOrd ?>%)</span>
				</div>
				<div class="progress mb-2" style="height:8px;">
					<div class="progress-bar bg-primary" role="progressbar" style="width: <?= $pOrd ?>%"></div>
				</div>
				<div class="d-flex justify-content-between mb-1">
					<span>Extraordinarios</span>
					<span class="fw-semibold">₡ <?= number_format($ext, 2, ',', '.') ?> (<?= $pExt ?>%)</span>
				</div>
				<div class="progress" style="height:8px;">
					<div class="progress-bar bg-info" role="progressbar" style="width: <?= $pExt ?>%"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Gráficos -->
<div class="row g-3">
	<div class="col-12 col-lg-7">
		<div class="card shadow-sm">
			<div class="card-header bg-white">
				<strong><i class="fa-solid fa-chart-area"></i> Ingresos vs Gastos (últimos meses)</strong>
			</div>
			<div class="card-body">
				<canvas id="lineChart" height="120"></canvas>
			</div>
		</div>
	</div>
	<div class="col-12 col-lg-5">
		<div class="card shadow-sm">
			<div class="card-header bg-white">
				<strong><i class="fa-solid fa-chart-pie"></i> Gastos por Categoría</strong>
			</div>
			<div class="card-body">
				<canvas id="doughnutChart" height="120"></canvas>
				<?php if (empty($gastosPorCategoria)): ?>
					<p class="text-muted mt-3 mb-0">Sin datos de categorías aún.</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<!-- Scripts de gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	const meses = <?= $meses ?? '[]' ?>;
	const ingresos = <?= $ingresos ?? '[]' ?>;
	const gastos = <?= $gastos ?? '[]' ?>;
	const categoriasData = <?= json_encode($gastosPorCategoria ?? []) ?>;

	// Line chart: Ingresos vs Gastos
	try {
		const ctxLine = document.getElementById('lineChart').getContext('2d');
		new Chart(ctxLine, {
			type: 'line',
			data: {
				labels: meses,
				datasets: [{
						label: 'Ingresos',
						data: ingresos,
						borderColor: 'rgba(13,110,253,0.9)',
						backgroundColor: 'rgba(13,110,253,0.15)',
						tension: 0.3,
						fill: true,
					},
					{
						label: 'Gastos',
						data: gastos,
						borderColor: 'rgba(220,53,69,0.9)',
						backgroundColor: 'rgba(220,53,69,0.15)',
						tension: 0.3,
						fill: true,
					}
				]
			},
			options: {
				responsive: true,
				plugins: {
					legend: {
						position: 'top'
					}
				},
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		});
	} catch (e) {
		console.warn('No se pudo renderizar lineChart', e);
	}

	// Doughnut chart: Gastos por categoría
	try {
		const labelsCat = categoriasData.map(i => i.categoria ?? 'Sin nombre');
		const totalsCat = categoriasData.map(i => Number(i.total ?? 0));
		const colors = [
			'#0d6efd', '#6610f2', '#6f42c1', '#d63384', '#dc3545', '#fd7e14',
			'#ffc107', '#198754', '#20c997', '#0dcaf0', '#6c757d', '#343a40'
		];

		const ctxPie = document.getElementById('doughnutChart').getContext('2d');
		new Chart(ctxPie, {
			type: 'doughnut',
			data: {
				labels: labelsCat,
				datasets: [{
					data: totalsCat,
					backgroundColor: labelsCat.map((_, idx) => colors[idx % colors.length])
				}]
			},
			options: {
				responsive: true,
				plugins: {
					legend: {
						position: 'bottom'
					}
				}
			}
		});
	} catch (e) {
		console.warn('No se pudo renderizar doughnutChart', e);
	}
</script>

<?= $this->endSection() ?>

<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>


<?= $this->endSection() ?>