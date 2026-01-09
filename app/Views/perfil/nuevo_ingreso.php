<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Ingreso - Registro de Gastos</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .tipo-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #666;
        }

        .tipo-info strong {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        .tipo-info ul {
            margin-left: 20px;
            margin-top: 5px;
        }

        .tipo-info li {
            margin-bottom: 5px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
            width: 100%;
            font-weight: 500;
        }

        .btn:hover {
            background: #5568d3;
        }

        .btn-secondary {
            background: #6c757d;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Agregar Nuevo Ingreso</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="tipo-info">
            <strong>📊 Tipos de Ingresos:</strong>
            <ul>
                <li><strong>Ordinario:</strong> Ingresos regulares y predecibles (salario, rentas, etc.)</li>
                <li><strong>Extraordinario:</strong> Ingresos ocasionales (bonos, regalos, ventas, etc.)</li>
            </ul>
        </div>

        <form action="<?= base_url('perfil/guardar-ingreso') ?>" method="post">
            <div class="form-group">
                <label for="monto">Monto: *</label>
                <input type="number" 
                       id="monto" 
                       name="monto" 
                       step="0.01" 
                       min="0.01" 
                       placeholder="0.00" 
                       required>
            </div>

            <div class="form-group">
                <label for="tipo">Tipo de Ingreso: *</label>
                <select id="tipo" name="tipo" required>
                    <option value="">Selecciona un tipo</option>
                    <option value="ordinario">💼 Ordinario (Regular)</option>
                    <option value="extraordinario">🎁 Extraordinario (Ocasional)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fecha_ingreso">Fecha del Ingreso: *</label>
                <input type="date" 
                       id="fecha_ingreso" 
                       name="fecha_ingreso" 
                       value="<?= date('Y-m-d') ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" 
                          name="descripcion" 
                          placeholder="Ej: Salario de enero, Bono anual, Venta de artículo..."></textarea>
            </div>

            <button type="submit" class="btn">💰 Guardar Ingreso</button>
            <a href="<?= base_url('perfil') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
