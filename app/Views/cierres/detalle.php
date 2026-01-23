<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<?php 
$meses = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];
$periodo = $meses[$cierre['mes']] . ' ' . $cierre['anio'];
$balanceClass = $cierre['balance'] >= 0 ? 'text-success' : 'text-danger';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0"><i class="bi bi-file-earmark-text text-info"></i> Cierre de <?= $periodo ?></h2>
        <small class="text-muted">Período consolidado e inmutable</small>
    </div>
    <a href="<?= base_url('cierres') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<!-- Resumen del cierre -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card shadow-sm border-success h-100">
            <div class="card-body text-center">
                <div class="text-muted mb-2"><i class="bi bi-cash-coin"></i> Total Ingresos</div>
                <div class="h3 text-success mb-0">₡ <?= number_format($cierre['total_ingresos'], 2, ',', '.') ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card shadow-sm border-danger h-100">
            <div class="card-body text-center">
                <div class="text-muted mb-2"><i class="bi bi-receipt"></i> Total Gastos</div>
                <div class="h3 text-danger mb-0">₡ <?= number_format($cierre['total_gastos'], 2, ',', '.') ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card shadow-sm border-<?= $cierre['balance'] >= 0 ? 'success' : 'danger' ?> h-100">
            <div class="card-body text-center">
                <div class="text-muted mb-2"><i class="bi bi-graph-up-arrow"></i> Balance</div>
                <div class="h3 <?= $balanceClass ?> mb-0">₡ <?= number_format($cierre['balance'], 2, ',', '.') ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
        <div class="card shadow-sm border-info h-100">
            <div class="card-body text-center">
                <div class="text-muted mb-2"><i class="bi bi-clock-history"></i> Generado</div>
                <div class="mb-0"><?= date('d/m/Y', strtotime($cierre['generado_en'])) ?></div>
                <small class="text-muted"><?= date('H:i', strtotime($cierre['generado_en'])) ?></small>
            </div>
        </div>
    </div>
</div>

<!-- Detalle de ingresos -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-cash-coin"></i> Ingresos del Período</h5>
    </div>
    <div class="card-body">
        <?php if (empty($ingresos)): ?>
            <p class="text-muted text-center mb-0">No hay ingresos registrados para este período.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-calendar-event"></i> Fecha</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th class="text-end">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ingresos as $ingreso): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($ingreso['fecha_ingreso'])) ?></td>
                                <td>
                                    <?= esc($ingreso['descripcion'] ?? 'Sin descripción') ?>
                                    <?php if (!empty($ingreso['es_recurrente'])): ?>
                                        <span class="badge bg-info ms-1">Recurrente</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $ingreso['tipo'] == 'ordinario' ? 'primary' : 'warning' ?>">
                                        <?= ucfirst($ingreso['tipo']) ?>
                                    </span>
                                </td>
                                <td class="text-end fw-semibold">₡ <?= number_format($ingreso['monto'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Detalle de gastos -->
<div class="card shadow-sm">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0"><i class="bi bi-receipt"></i> Gastos del Período</h5>
    </div>
    <div class="card-body">
        <?php if (empty($gastos)): ?>
            <p class="text-muted text-center mb-0">No hay gastos registrados para este período.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-calendar-event"></i> Fecha</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th class="text-end">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gastos as $gasto): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($gasto['fecha_gasto'])) ?></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= esc($gasto['categoria_nombre'] ?? 'Sin categoría') ?>
                                    </span>
                                </td>
                                <td><?= esc($gasto['descripcion'] ?? 'Sin descripción') ?></td>
                                <td class="text-end fw-semibold">₡ <?= number_format($gasto['monto'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
