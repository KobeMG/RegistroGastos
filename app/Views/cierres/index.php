<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0"><i class="bi bi-calendar-check text-warning"></i> Historial de Cierres de Mes</h2>
        <small class="text-muted">Períodos cerrados y consolidados</small>
    </div>
    <div>
        <a href="<?= base_url('home') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver al Dashboard
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (empty($cierres)): ?>
            <div class="alert alert-info text-center mb-0">
                <i class="bi bi-info-circle"></i> No hay cierres de mes registrados aún.
                <br><small>Los cierres se generan automáticamente al iniciar sesión en un nuevo mes.</small>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="bi bi-calendar3"></i> Período</th>
                            <th class="text-end">Total Ingresos</th>
                            <th class="text-end">Total Gastos</th>
                            <th class="text-end">Balance</th>
                            <th class="text-center">Generado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $meses = [
                            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                        ];
                        foreach ($cierres as $cierre): 
                            $balanceClass = $cierre['balance'] >= 0 ? 'text-success' : 'text-danger';
                        ?>
                            <tr>
                                <td>
                                    <strong><?= $meses[$cierre['mes']] ?> <?= $cierre['anio'] ?></strong>
                                </td>
                                <td class="text-end text-success fw-semibold">
                                    ₡ <?= number_format($cierre['total_ingresos'], 2, ',', '.') ?>
                                </td>
                                <td class="text-end text-danger fw-semibold">
                                    ₡ <?= number_format($cierre['total_gastos'], 2, ',', '.') ?>
                                </td>
                                <td class="text-end <?= $balanceClass ?> fw-bold">
                                    ₡ <?= number_format($cierre['balance'], 2, ',', '.') ?>
                                </td>
                                <td class="text-center">
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($cierre['generado_en'])) ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('cierres/ver/' . $cierre['id']) ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Ver Detalle
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
