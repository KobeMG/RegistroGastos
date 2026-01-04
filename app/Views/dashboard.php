<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>

<?php if (isset($usuario) && $usuario): ?>

  <h1>Gastos de <?= esc($usuario['nombre']) ?></h1>
  
  <?php if (!empty($gastos)): ?>
    <div class="table-responsive mt-4">
      <table class="table table-striped table-hover">
        <thead class="table-dark">
          <tr>
            <th>Fecha</th>
            <th>Categoría</th>
            <th>Descripción</th>
            <th>Monto</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($gastos as $gasto): ?>
            <tr>
              <td><?= esc($gasto['fecha_gasto']) ?></td>
              <td><?= esc($gasto['categoria_nombre'] ?? 'Sin categoría') ?></td>
              <td><?= esc($gasto['descripcion']) ?></td>
              <td>$<?= number_format($gasto['monto'], 2) ?></td>
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

<?= $this->endSection() ?>