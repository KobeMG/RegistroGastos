<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Registro de Gastos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            color: #333;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #5568d3;
        }

        .btn-danger {
            background: #e74c3c;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-success {
            background: #27ae60;
        }

        .btn-success:hover {
            background: #229954;
        }

        .btn-small {
            padding: 5px 15px;
            font-size: 12px;
            margin: 0 5px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 14px;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .stat-card .amount {
            font-size: 28px;
            font-weight: bold;
        }

        .stat-card.ordinario {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        }

        .stat-card.extraordinario {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }

        .stat-card.total {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        }

        .ingresos-list {
            margin-top: 20px;
        }

        .ingreso-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ingreso-info {
            flex: 1;
        }

        .ingreso-tipo {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .tipo-ordinario {
            background: #3498db;
            color: white;
        }

        .tipo-extraordinario {
            background: #e74c3c;
            color: white;
        }

        .ingreso-monto {
            font-size: 24px;
            font-weight: bold;
            color: #27ae60;
        }

        .ingreso-actions {
            display: flex;
            gap: 5px;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Mi Perfil</h1>
            <a href="<?= base_url('home') ?>" class="btn">← Volver al Dashboard</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="grid">
            <!-- Información del Usuario -->
            <div class="card">
                <h2>Información Personal</h2>
                <form action="<?= base_url('perfil/actualizar') ?>" method="post">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" value="<?= esc($usuario['nombre']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="<?= esc($usuario['email']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Nueva Contraseña (dejar vacío para no cambiar):</label>
                        <input type="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-success">Actualizar Perfil</button>
                </form>
            </div>

            <!-- Estadísticas de Ingresos -->
            <div class="card">
                <h2>Resumen de Ingresos</h2>
                <div class="stats">
                    <div class="stat-card ordinario">
                        <h3>Ingresos Ordinarios</h3>
                        <div class="amount">₡<?= number_format($totalOrdinarios, 2) ?></div>
                    </div>
                    <div class="stat-card extraordinario">
                        <h3>Ingresos Extraordinarios</h3>
                        <div class="amount">₡<?= number_format($totalExtraordinarios, 2) ?></div>
                    </div>
                    <div class="stat-card total">
                        <h3>Total Ingresos</h3>
                        <div class="amount">₡<?= number_format($totalIngresos, 2) ?></div>
                    </div>
                </div>

                <a href="<?= base_url('perfil/nuevo-ingreso') ?>" class="btn btn-success">+ Agregar Ingreso</a>
            </div>
        </div>

        <!-- Lista de Ingresos -->
        <div class="card">
            <h2>Historial de Ingresos</h2>
            <div class="ingresos-list">
                <?php if (empty($ingresos)): ?>
                    <p style="text-align: center; color: #999; padding: 20px;">
                        No hay ingresos registrados. ¡Agrega tu primer ingreso!
                    </p>
                <?php else: ?>
                    <?php foreach ($ingresos as $ingreso): ?>
                        <div class="ingreso-item">
                            <div class="ingreso-info">
                                <span class="ingreso-tipo tipo-<?= $ingreso['tipo'] ?>">
                                    <?= ucfirst($ingreso['tipo']) ?>
                                </span>
                                <div style="margin-top: 5px;">
                                    <strong><?= esc($ingreso['descripcion'] ?? 'Sin descripción') ?></strong>
                                </div>
                                <div style="font-size: 12px; color: #666; margin-top: 5px;">
                                    📅 <?= date('d/m/Y', strtotime($ingreso['fecha_ingreso'])) ?>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div class="ingreso-monto">₡<?= number_format($ingreso['monto'], 2) ?></div>
                                <div class="ingreso-actions">
                                    <a href="<?= base_url('perfil/editar-ingreso/' . $ingreso['id']) ?>" 
                                       class="btn btn-small">Editar</a>
                                    <form action="<?= base_url('perfil/eliminar-ingreso/' . $ingreso['id']) ?>" 
                                          method="post" 
                                          style="display: inline;"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este ingreso?')">
                                        <button type="submit" class="btn btn-danger btn-small">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
