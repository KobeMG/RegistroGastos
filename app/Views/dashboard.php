<?= $this->extend('layouts/navbar') ?>

<?= $this->section('content') ?>
  <h1>Gastos de <?= esc($usuario['nombre']) ?></h1>
  <ul class="list-group">
  <li class="list-group-item">An item</li>
  <li class="list-group-item">A second item</li>
  <li class="list-group-item">A third item</li>
  <li class="list-group-item">A fourth item</li>
  <li class="list-group-item">And a fifth one</li>
</ul>
<?= $this->endSection() ?>