<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Gastos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; color: #0d6efd !important; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-wallet"></i> GastosPro</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($usuario) && $usuario): ?>
                        <li class="nav-item">
                            <span class="navbar-text text-light me-3">
                                <i class="fa-solid fa-user"></i> Hola, <?= esc($usuario['nombre']) ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalGasto">
                                <i class="fa-solid fa-plus"></i> Nuevo Gasto
                            </button>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light ms-2" href="<?= base_url('logout') ?>">
                                <i class="fa-solid fa-right-from-bracket"></i> Salir
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('') ?>">Iniciar Sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Modal para registrar gasto -->
    <div class="modal fade" id="modalGasto" tabindex="-1" aria-labelledby="modalGastoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalGastoLabel"><i class="fa-solid fa-money-bill"></i> Registrar Nuevo Gasto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('gastos/guardar') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria_id" name="categoria_id" required>
                                <option value="" selected disabled>Selecciona una categoría</option>
                                <?php if (isset($categorias) && $categorias): ?>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id'] ?>"><?= esc($categoria['nombre']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" class="form-control" id="monto" name="monto" step="0.01" placeholder="0.00" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Detalles del gasto (opcional)"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_gasto" class="form-label">Fecha del Gasto</label>
                            <input type="date" class="form-control" id="fecha_gasto" name="fecha_gasto" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Guardar Gasto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>