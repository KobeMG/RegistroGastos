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
    <div class="col-12 col-lg-6">
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

    <!-- Token de API -->
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white">
                <strong><i class="fa-solid fa-key"></i> Token de API</strong>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('api_token')): ?>
                    <!-- Token recién generado - mostrar completo UNA VEZ -->
                    <div class="alert alert-warning" role="alert">
                        <i class="fa-solid fa-exclamation-triangle"></i> <strong>¡IMPORTANTE!</strong> 
                        Copia este token ahora. No podrás verlo nuevamente por seguridad.
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tu Token API:</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-monospace" id="tokenCompleto" value="<?= session()->getFlashdata('api_token') ?>" readonly>
                            <button class="btn btn-outline-primary" type="button" onclick="copiarToken()">
                                <i class="fa-solid fa-copy"></i> Copiar
                            </button>
                        </div>
                        <small class="text-muted">Úsalo en el header: Authorization: Bearer {token}</small>
                    </div>
                    <div class="alert alert-info mb-0">
                        <small>
                            <i class="fa-solid fa-info-circle"></i> 
                            Úsalo para registrar gastos desde iPhone Shortcuts o cualquier aplicación externa.
                        </small>
                    </div>
                <?php elseif (!empty($usuario['api_token'])): ?>
                    <!-- Token ya existe - mostrar parcial -->
                    <div class="mb-3">
                        <label class="form-label">Estado del Token:</label>
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-success me-2">
                                <i class="fa-solid fa-check-circle"></i> Activo
                            </span>
                            <code class="text-muted">****...<?= substr($usuario['api_token'], -6) ?></code>
                        </div>
                        <small class="text-muted">Token creado y activo para uso en API</small>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <form action="<?= base_url('perfil/generar-token') ?>" method="post" onsubmit="return confirm('¿Regenerar el token? El token actual dejará de funcionar.')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fa-solid fa-rotate"></i> Regenerar Token
                            </button>
                        </form>
                        <form action="<?= base_url('perfil/revocar-token') ?>" method="post" onsubmit="return confirm('¿Revocar el token? No podrás usar la API hasta generar uno nuevo.')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fa-solid fa-trash"></i> Revocar Token
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <!-- Sin token -->
                    <div class="text-center py-4">
                        <i class="fa-solid fa-key fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-3">No tienes un token de API generado</p>
                        <form action="<?= base_url('perfil/generar-token') ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-plus"></i> Generar Token API
                            </button>
                        </form>
                        <small class="text-muted d-block mt-3">
                            El token te permitirá registrar gastos desde aplicaciones externas
                        </small>
                    </div>
                <?php endif; ?>
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
                    <div class="alert alert-info mb-0" role="alert">
                        <small><i class="fa-solid fa-circle-info"></i> Los ingresos <strong>ordinarios</strong> se copiarán automáticamente al mes siguiente en el cierre.</small>
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
function cargarDatosIngreso(id, monto, tipo, descripcion, fecha) {
    document.getElementById('tipo_editar').value = tipo;
    document.getElementById('monto_editar').value = monto;
    document.getElementById('descripcion_editar').value = descripcion;
    document.getElementById('fecha_ingreso_editar').value = fecha;
    document.getElementById('frmEditarIngreso').action = '<?= base_url('perfil/actualizar-ingreso/') ?>' + id;
}

function copiarToken() {
    const tokenInput = document.getElementById('tokenCompleto');
    tokenInput.select();
    tokenInput.setSelectionRange(0, 99999); // Para móviles
    
    navigator.clipboard.writeText(tokenInput.value).then(() => {
        // Cambiar el botón temporalmente
        const btn = event.target.closest('button');
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-check"></i> Copiado!';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-primary');
        }, 2000);
    }).catch(err => {
        alert('Error al copiar: ' + err);
    });
}
</script>

<?= $this->endSection() ?>
