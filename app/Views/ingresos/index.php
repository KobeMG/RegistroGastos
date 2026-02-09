<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>

<?php if (isset($usuario) && $usuario): ?>

  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 class="mb-0"><i class="fa-solid fa-arrow-up text-success"></i> Ingresos</h2>
      <small class="text-muted">Gestiona tus ingresos registrados</small>
    </div>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalIngreso">
      <i class="fa-solid fa-plus"></i> Agregar Ingreso
    </button>
  </div>
  
  <?php if (!empty($ingresos)): ?>
    <div class="table-responsive mt-4">
      <table class="table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Monto</th>
            <th>Modificación</th>
            <th>Eliminación</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($ingresos as $ingreso): ?>
            <tr>
              <td><?= esc($ingreso['fecha_ingreso']) ?></td>
              <td>
                <span class="badge bg-<?= $ingreso['tipo'] === 'ordinario' ? 'primary' : 'info' ?>">
                  <?= esc(ucfirst($ingreso['tipo'])) ?>
                </span>
              </td>
              <td><?= esc($ingreso['descripcion'] ?? 'Sin descripción') ?></td>
              <td class="text-success fw-bold">₡<?= number_format($ingreso['monto'], 2) ?></td>
              <td>
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarIngreso" onclick="cargarDatosIngreso(<?= $ingreso['id'] ?>, '<?= esc($ingreso['tipo']) ?>', <?= $ingreso['monto'] ?>, '<?= esc($ingreso['descripcion']) ?>', '<?= esc($ingreso['fecha_ingreso']) ?>')">
                  <i class="fa-solid fa-pen-to-square"></i> Modificar
                </button>
              </td>
              <td>
                <form action="<?= base_url('ingresos/eliminar/' . $ingreso['id']) ?>" method="post" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar este ingreso?');">
                  <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i> Eliminar
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info mt-4" role="alert">
      No tienes ingresos registrados todavía.
    </div>
  <?php endif; ?>

<?php else: ?>
  <div class="alert alert-warning" role="alert">
    Debes iniciar sesión para ver el contenido del dashboard.
  </div>
<?php endif; ?>

<!-- Modal para crear nuevo ingreso -->
<div class="modal fade" id="modalIngreso" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Nuevo Ingreso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?= base_url('ingresos/guardar') ?>" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Ingreso</label>
            <select class="form-select" id="tipo" name="tipo" required>
              <option value="">Selecciona un tipo</option>
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
            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
          </div>
          <div class="mb-3">
            <label for="fecha_ingreso" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?= date('Y-m-d') ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar Ingreso</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal para editar ingreso -->
<div class="modal fade" id="modalEditarIngreso" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Editar Ingreso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditarIngreso" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="tipo_edit" class="form-label">Tipo de Ingreso</label>
            <select class="form-select" id="tipo_edit" name="tipo" required>
              <option value="">Selecciona un tipo</option>
              <option value="ordinario">Ordinario</option>
              <option value="extraordinario">Extraordinario</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="monto_edit" class="form-label">Monto (₡)</label>
            <input type="number" class="form-control" id="monto_edit" name="monto" step="0.01" required>
          </div>
          <div class="mb-3">
            <label for="descripcion_edit" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcion_edit" name="descripcion" required>
          </div>
          <div class="mb-3">
            <label for="fecha_ingreso_edit" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha_ingreso_edit" name="fecha_ingreso" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Actualizar Ingreso</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  let ingresoIdActual = null;

  function cargarDatosIngreso(id, tipo, monto, descripcion, fecha) {
    ingresoIdActual = id;
    document.getElementById('tipo_edit').value = tipo;
    document.getElementById('monto_edit').value = monto;
    document.getElementById('descripcion_edit').value = descripcion;
    document.getElementById('fecha_ingreso_edit').value = fecha;
    document.getElementById('formEditarIngreso').action = '<?= base_url('ingresos/actualizar/') ?>' + id;
  }
</script>

<?= $this->endSection() ?>
