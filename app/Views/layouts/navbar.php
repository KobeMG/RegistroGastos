<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Gastos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .navbar-brand { font-weight: bold; color: #0d6efd !important; }
        
        /* Estilos del Footer */
        .footer {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #ecf0f1;
            padding: 3rem 0 1.5rem;
            margin-top: 3rem;
            border-top: 3px solid #0d6efd;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
        }
        
        .footer-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0d6efd;
        }
        
        .footer-text {
            color: #bdc3c7;
            margin: 0;
        }
        
        .footer-link {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .footer-link:hover {
            color: #0a58ca;
            text-decoration: underline;
        }
        
        .footer-social {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .footer-social a {
            color: #ecf0f1;
            font-size: 1.3rem;
            transition: all 0.3s ease;
        }
        
        .footer-social a:hover {
            color: #0d6efd;
            transform: scale(1.2);
        }
        
        .footer-divider {
            border-top: 1px solid #404040;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
        }
        
        .footer-bottom {
            text-align: center;
            color: #95a5a6;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .footer-content {
                justify-content: center;
                text-align: center;
            }
            
            .footer-social {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" ><i class="fa-solid fa-wallet"></i> GastosPro</a>
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
                            <a class="btn btn-success text-white me-2" href="<?= base_url('dashboard-financiero') ?>">
                                <i class="fa-solid fa-chart-line"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-warning text-white me-2" href="<?= base_url('cierres') ?>">
                                <i class="fa-solid fa-calendar-check"></i> Cierres
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-info text-white me-2" href="<?= base_url('perfil') ?>">
                                <i class="fa-solid fa-user-circle"></i> Mi Perfil
                            </a>
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
                            <label for="monto" class="form-label">Monto (₡)</label>
                            <input type="number" class="form-control" id="monto" name="monto" step="0.01" placeholder="₡0.00" required>
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

    <!-- Modal para editar gasto -->
    <div class="modal fade" id="modalEditarGasto" tabindex="-1" aria-labelledby="modalEditarGastoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarGastoLabel"><i class="fa-solid fa-money-bill"></i> Editar Gasto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="frmEditarGasto" method="POST">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="categoria_id_editar" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria_id_editar" name="categoria_id" required>
                                <option value="" selected disabled>Selecciona una categoría</option>
                                <?php if (isset($categorias) && $categorias): ?>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id'] ?>"><?= esc($categoria['nombre']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="monto_editar" class="form-label">Monto (₡)</label>
                            <input type="number" class="form-control" id="monto_editar" name="monto" step="0.01" placeholder="₡0.00" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion_editar" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion_editar" name="descripcion" rows="3" placeholder="Detalles del gasto (opcional)"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_gasto_editar" class="form-label">Fecha del Gasto</label>
                            <input type="date" class="form-control" id="fecha_gasto_editar" name="fecha_gasto" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Actualizar Gasto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para cargar datos del gasto en el modal de edición
        function cargarDatosGasto(id, categoriaId, monto, descripcion, fechaGasto) {
            // Llenar los campos del formulario
            document.getElementById('categoria_id_editar').value = categoriaId;
            document.getElementById('monto_editar').value = monto;
            document.getElementById('descripcion_editar').value = descripcion;
            document.getElementById('fecha_gasto_editar').value = fechaGasto;
            
            // Actualizar la acción del formulario con el ID del gasto
            document.getElementById('frmEditarGasto').action = '<?= base_url('gastos/actualizar/') ?>' + id;
        }
    </script>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <i class="fa-solid fa-wallet"></i> GastosPro
                </div>
                <div class="footer-text">
                    Desarrollado por <strong>KodeCreative</strong>, una marca aspiracional de 
                    <a href="https://www.linkedin.com/in/kobemg/" target="_blank" class="footer-link">KobeMG</a>
                </div>
                <div class="footer-social">
                    <a href="https://www.linkedin.com/in/kobemg/" target="_blank" title="LinkedIn">
                        <i class="fa-brands fa-linkedin"></i>
                    </a>
                    <a href="https://github.com/KobeMG" target="_blank" title="GitHub">
                        <i class="fa-brands fa-github"></i>
                    </a>
                </div>
            </div>
            <div class="footer-divider">
                <div class="footer-bottom">
                    <p>&copy; <?= date('Y') ?> KodeCreative. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>