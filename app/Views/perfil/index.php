<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="mb-0"><i class="fa-solid fa-user-circle text-info"></i> Mi Perfil</h2>
        <small class="text-muted">Gestiona tu información personal e ingresos</small>
    </div>
    <div>
        <a href="<?= base_url('home') ?>" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-solid fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Resumen de ingresos -->
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="card shadow-sm border-primary h-100">
            <div class="card-body text-center">
                <div class="text-muted mb-2"><i class="fa-solid fa-money-bill-wave"></i> Ingresos Ordinarios</div>
                <div class="h3 text-primary mb-0">₡ <?= number_format($totalOrdinarios, 2, ',', '.') ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card shadow-sm border-warning h-100">
            <div class="card-body text-center">
                <div class="text-muted mb-2"><i class="fa-solid fa-gift"></i> Ingresos Extraordinarios</div>
                <div class="h3 text-warning mb-0">₡ <?= number_format($totalExtraordinarios, 2, ',', '.') ?></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card shadow-sm border-success h-100">
            <div class="card-body text-center">
                <div class="text-muted mb-2"><i class="fa-solid fa-coins"></i> Total Ingresos</div>
                <div class="h3 text-success mb-0">₡ <?= number_format($totalIngresos, 2, ',', '.') ?></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Información personal -->
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <strong><i class="fa-solid fa-user-edit"></i> Información Personal</strong>
            </div>
            <div class="card-body">
                <form action="<?= base_url('perfil/actualizar') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= esc($usuario['nombre']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= esc($usuario['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Dejar vacío para no cambiar">
                        <small class="text-muted">Solo completa si deseas cambiar tu contraseña</small>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fa-solid fa-save"></i> Actualizar Perfil
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Historial de ingresos -->
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong><i class="fa-solid fa-list"></i> Historial de Ingresos</strong>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalNuevoIngreso">
                    <i class="fa-solid fa-plus"></i> Agregar Ingreso
                </button>
            </div>
            <div class="card-body">
                <?php if (empty($ingresos)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="fa-solid fa-inbox fa-3x mb-3 d-block"></i>
                        <p>No hay ingresos registrados. ¡Agrega tu primer ingreso!</p>
                    </div>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($ingresos as $ingreso): ?>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <span class="badge bg-<?= $ingreso['tipo'] == 'ordinario' ? 'primary' : 'warning' ?> mb-2">
                                            <?= ucfirst($ingreso['tipo']) ?>
                                        </span>
                                        <?php if (!empty($ingreso['es_recurrente'])): ?>
                                            <span class="badge bg-info mb-2 ms-1">Recurrente</span>
                                        <?php endif; ?>
                                        <div class="fw-semibold"><?= esc($ingreso['descripcion'] ?? 'Sin descripción') ?></div>
                                        <small class="text-muted">
                                            <i class="fa-solid fa-calendar"></i> <?= date('d/m/Y', strtotime($ingreso['fecha_ingreso'])) ?>
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <div class="h5 text-success mb-2">₡ <?= number_format($ingreso['monto'], 2, ',', '.') ?></div>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" 
                                                    onclick="cargarDatosIngreso(<?= $ingreso['id'] ?>, <?= $ingreso['monto'] ?>, '<?= esc($ingreso['tipo']) ?>', '<?= esc($ingreso['descripcion'] ?? '') ?>', '<?= $ingreso['fecha_ingreso'] ?>', <?= !empty($ingreso['es_recurrente']) ? 'true' : 'false' ?>)"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalEditarIngreso">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                            <form action="<?= base_url('perfil/eliminar-ingreso/' . $ingreso['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar este ingreso?')">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Ingreso -->
<div class="modal fade" id="modalNuevoIngreso" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-plus-circle"></i> Agregar Ingreso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('perfil/guardar-ingreso') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo de Ingreso</label>
                        <select class="form-select" id="tipo" name="tipo" required>
                            <option value="ordinario">Ordinario</option>
                            <option value="extraordinario">Extraordinario</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto (₡)</label>
                        <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                        <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="es_recurrente" name="es_recurrente" value="1">
                        <label class="form-check-label" for="es_recurrente">
                            Ingreso recurrente (se copiará automáticamente cada mes)
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-save"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Ingreso -->
<div class="modal fade" id="modalEditarIngreso" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-edit"></i> Editar Ingreso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="frmEditarIngreso" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipo_editar" class="form-label">Tipo de Ingreso</label>
                        <select class="form-select" id="tipo_editar" name="tipo" required>
                            <option value="ordinario">Ordinario</option>
                            <option value="extraordinario">Extraordinario</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="monto_editar" class="form-label">Monto (₡)</label>
                        <input type="number" class="form-control" id="monto_editar" name="monto" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion_editar" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion_editar" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_ingreso_editar" class="form-label">Fecha de Ingreso</label>
                        <input type="date" class="form-control" id="fecha_ingreso_editar" name="fecha_ingreso" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="es_recurrente_editar" name="es_recurrente" value="1">
                        <label class="form-check-label" for="es_recurrente_editar">
                            Ingreso recurrente
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function cargarDatosIngreso(id, monto, tipo, descripcion, fecha, esRecurrente) {
    document.getElementById('tipo_editar').value = tipo;
    document.getElementById('monto_editar').value = monto;
    document.getElementById('descripcion_editar').value = descripcion;
    document.getElementById('fecha_ingreso_editar').value = fecha;
    document.getElementById('es_recurrente_editar').checked = esRecurrente;
    document.getElementById('frmEditarIngreso').action = '<?= base_url('perfil/actualizar-ingreso/') ?>' + id;
}
</script>

<?= $this->endSection() ?>
