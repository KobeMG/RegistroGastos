<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="mb-0"><i class="fa-solid fa-user-circle text-info"></i> Mi Perfil</h2>
        <small class="text-muted">Gestiona tu información personal e ingresos</small>
    </div>
    <div>
        <a href="<?= base_url('dashboard-financiero') ?>" class="btn btn-outline-secondary">
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



<div class="row g-3">
    <!-- Información personal -->
    <div class="col-12 col-lg-6 mx-auto">
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
