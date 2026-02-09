<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>

<?php if (isset($usuario) && $usuario): ?>

  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h2 class="mb-0"><i class="fa-solid fa-receipt"></i> Gastos</h2>
      <small class="text-muted">Gestiona tus gastos registrados</small>
    </div>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalGasto">
      <i class="fa-solid fa-plus"></i> Agregar Gasto
    </button>
  </div>
  
  <?php if (!empty($gastos)): ?>
    <div class="table-responsive mt-4">
      <table class="table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>Fecha</th>
            <th>Categoría</th>
            <th>Descripción</th>
            <th>Monto</th>
            <th>Modificación</th>
            <th>Eliminación</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($gastos as $gasto): ?>
            <tr>
              <td><?= esc($gasto['fecha_gasto']) ?></td>
              <td><?= esc($gasto['categoria_nombre'] ?? 'Sin categoría') ?></td>
              <td><?= esc($gasto['descripcion']) ?></td>
              <td>₡<?= number_format($gasto['monto'], 2) ?></td>
              <td>
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarGasto" onclick="cargarDatosGasto(<?= $gasto['id'] ?>, '<?= esc($gasto['categoria_id']) ?>', <?= $gasto['monto'] ?>, '<?= esc($gasto['descripcion']) ?>', '<?= esc($gasto['fecha_gasto']) ?>')">
                  <i class="fa-solid fa-pen-to-square"></i> Modificar
                </button>
              </td>
              <td>
                <form action="<?= base_url('gastos/eliminar/' . $gasto['id']) ?>" method="post" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar este gasto?');">
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
      No tienes gastos registrados todavía.
    </div>
  <?php endif; ?>

<?php else: ?>
  <div class="alert alert-warning" role="alert">
    Debes iniciar sesión para ver el contenido del dashboard.
  </div>
<?php endif; ?>

<!-- Modal para crear nuevo gasto -->
<div class="modal fade" id="modalGasto" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Nuevo Gasto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="<?= base_url('gastos/guardar') ?>" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select class="form-select" id="categoria_id" name="categoria_id" required>
              <option value="">Selecciona una categoría</option>
              <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>"><?= esc($categoria['nombre']) ?></option>
              <?php endforeach; ?>
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
            <label for="fecha_gasto" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha_gasto" name="fecha_gasto" value="<?= date('Y-m-d') ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Guardar Gasto</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal para editar gasto -->
<div class="modal fade" id="modalEditarGasto" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-pen-to-square"></i> Editar Gasto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditarGasto" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="categoria_id_edit" class="form-label">Categoría</label>
            <select class="form-select" id="categoria_id_edit" name="categoria_id" required>
              <option value="">Selecciona una categoría</option>
              <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>"><?= esc($categoria['nombre']) ?></option>
              <?php endforeach; ?>
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
            <label for="fecha_gasto_edit" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha_gasto_edit" name="fecha_gasto" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-warning">Actualizar Gasto</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  let gastoIdActual = null;

  function cargarDatosGasto(id, categoriaId, monto, descripcion, fecha) {
    gastoIdActual = id;
    document.getElementById('categoria_id_edit').value = categoriaId;
    document.getElementById('monto_edit').value = monto;
    document.getElementById('descripcion_edit').value = descripcion;
    document.getElementById('fecha_gasto_edit').value = fecha;
    document.getElementById('formEditarGasto').action = '<?= base_url('gastos/actualizar/') ?>' + id;
  }
</script>

<?= $this->endSection() ?>
