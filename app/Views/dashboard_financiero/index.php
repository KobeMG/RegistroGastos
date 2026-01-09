<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Financiero - Registro de Gastos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.9) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .container-main {
            padding: 30px 15px;
        }

        .header-section {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .header-section h1 {
            color: #333;
            margin: 0;
            font-weight: bold;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
        }

        .stat-card.ingresos::before {
            background: linear-gradient(90deg, #27ae60, #229954);
        }

        .stat-card.gastos::before {
            background: linear-gradient(90deg, #e74c3c, #c0392b);
        }

        .stat-card.balance::before {
            background: linear-gradient(90deg, #3498db, #2980b9);
        }

        .stat-card h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .stat-card .amount {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
        }

        .stat-card.ingresos .amount {
            color: #27ae60;
        }

        .stat-card.gastos .amount {
            color: #e74c3c;
        }

        .stat-card.balance .amount {
            color: #3498db;
        }

        .stat-card.balance.negative .amount {
            color: #e74c3c;
        }

        .stat-card .icon {
            font-size: 40px;
            opacity: 0.1;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        .chart-container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .chart-container h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .chart-wrapper {
            position: relative;
            height: 350px;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .btn-back {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: #667eea;
            color: white;
        }

        @media (max-width: 768px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }

            .stat-card .amount {
                font-size: 24px;
            }

            .chart-wrapper {
                height: 250px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('home') ?>">
                <i class="fa-solid fa-chart-line"></i> GastosPro - Dashboard Financiero
            </a>
            <div class="ms-auto">
                <span class="text-white me-3">
                    <i class="fa-solid fa-user"></i> <?= esc($usuario['nombre']) ?>
                </span>
            </div>
        </div>
    </nav>

    <div class="container container-main">
        <!-- Header -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="fa-solid fa-chart-pie"></i> Dashboard Financiero</h1>
                    <p class="text-muted mb-0">Análisis completo de tus ingresos y gastos</p>
                </div>
                <a href="<?= base_url('home') ?>" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card ingresos">
                <h3><i class="fa-solid fa-arrow-up"></i> Total Ingresos</h3>
                <div class="amount">₡<?= number_format($totalIngresos, 2) ?></div>
                <small class="text-muted">Todos los períodos</small>
                <i class="fa-solid fa-coins icon" style="color: #27ae60;"></i>
            </div>

            <div class="stat-card gastos">
                <h3><i class="fa-solid fa-arrow-down"></i> Total Gastos</h3>
                <div class="amount">₡<?= number_format($totalGastos, 2) ?></div>
                <small class="text-muted">Todos los períodos</small>
                <i class="fa-solid fa-shopping-cart icon" style="color: #e74c3c;"></i>
            </div>

            <div class="stat-card balance <?= $balance < 0 ? 'negative' : '' ?>">
                <h3><i class="fa-solid fa-scale-balanced"></i> Balance</h3>
                <div class="amount">₡<?= number_format($balance, 2) ?></div>
                <small class="text-muted">
                    <?php if ($balance >= 0): ?>
                        <i class="fa-solid fa-check-circle text-success"></i> Superávit
                    <?php else: ?>
                        <i class="fa-solid fa-exclamation-triangle text-danger"></i> Déficit
                    <?php endif; ?>
                </small>
                <i class="fa-solid fa-wallet icon" style="color: #3498db;"></i>
            </div>
        </div>

        <!-- Main Chart: Ingresos vs Gastos -->
        <div class="chart-container">
            <h2><i class="fa-solid fa-chart-column"></i> Comparación Mensual: Ingresos vs Gastos</h2>
            <div class="chart-wrapper">
                <canvas id="chartIngresosVsGastos"></canvas>
            </div>
        </div>

        <!-- Secondary Charts Grid -->
        <div class="charts-grid">
            <!-- Gastos por Categoría -->
            <div class="chart-container">
                <h2><i class="fa-solid fa-chart-pie"></i> Distribución de Gastos por Categoría</h2>
                <div class="chart-wrapper">
                    <canvas id="chartGastosPorCategoria"></canvas>
                </div>
            </div>

            <!-- Tipos de Ingresos -->
            <div class="chart-container">
                <h2><i class="fa-solid fa-chart-simple"></i> Tipos de Ingresos</h2>
                <div class="chart-wrapper">
                    <canvas id="chartTiposIngresos"></canvas>
                </div>
            </div>
        </div>

        <!-- Balance Chart -->
        <div class="chart-container">
            <h2><i class="fa-solid fa-chart-area"></i> Tendencia de Balance Mensual</h2>
            <div class="chart-wrapper">
                <canvas id="chartBalance"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Datos desde PHP
        const meses = <?= $meses ?>;
        const ingresos = <?= $ingresos ?>;
        const gastos = <?= $gastos ?>;

        // Configuración común
        Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
        Chart.defaults.font.size = 12;

        // 1. Gráfico de Ingresos vs Gastos (Barras)
        const ctxIngresosVsGastos = document.getElementById('chartIngresosVsGastos').getContext('2d');
        new Chart(ctxIngresosVsGastos, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [
                    {
                        label: 'Ingresos',
                        data: ingresos,
                        backgroundColor: 'rgba(39, 174, 96, 0.7)',
                        borderColor: 'rgba(39, 174, 96, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Gastos',
                        data: gastos,
                        backgroundColor: 'rgba(231, 76, 60, 0.7)',
                        borderColor: 'rgba(231, 76, 60, 1)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += '₡' + context.parsed.y.toLocaleString('es-CR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₡' + value.toLocaleString('es-CR');
                            }
                        }
                    }
                }
            }
        });

        // 2. Gráfico de Gastos por Categoría (Pie)
        const ctxGastosPorCategoria = document.getElementById('chartGastosPorCategoria').getContext('2d');
        const categoriasData = <?= json_encode($gastosPorCategoria) ?>;
        const categorias = categoriasData.map(item => item.categoria || 'Sin categoría');
        const montosCategoria = categoriasData.map(item => parseFloat(item.total));
        
        const coloresCategoria = [
            'rgba(231, 76, 60, 0.8)',
            'rgba(52, 152, 219, 0.8)',
            'rgba(46, 204, 113, 0.8)',
            'rgba(155, 89, 182, 0.8)',
            'rgba(241, 196, 15, 0.8)',
            'rgba(230, 126, 34, 0.8)',
            'rgba(149, 165, 166, 0.8)',
            'rgba(26, 188, 156, 0.8)'
        ];

        new Chart(ctxGastosPorCategoria, {
            type: 'doughnut',
            data: {
                labels: categorias,
                datasets: [{
                    data: montosCategoria,
                    backgroundColor: coloresCategoria,
                    borderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ₡' + value.toLocaleString('es-CR', {minimumFractionDigits: 2}) + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // 3. Gráfico de Tipos de Ingresos (Pie)
        const ctxTiposIngresos = document.getElementById('chartTiposIngresos').getContext('2d');
        new Chart(ctxTiposIngresos, {
            type: 'pie',
            data: {
                labels: ['Ingresos Ordinarios', 'Ingresos Extraordinarios'],
                datasets: [{
                    data: [<?= $totalOrdinarios ?>, <?= $totalExtraordinarios ?>],
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.8)',
                        'rgba(155, 89, 182, 0.8)'
                    ],
                    borderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = <?= $totalIngresos ?>;
                                const percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ₡' + value.toLocaleString('es-CR', {minimumFractionDigits: 2}) + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // 4. Gráfico de Balance (Línea)
        const ctxBalance = document.getElementById('chartBalance').getContext('2d');
        const balances = ingresos.map((ingreso, index) => ingreso - gastos[index]);
        
        new Chart(ctxBalance, {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Balance Mensual',
                    data: balances,
                    borderColor: 'rgba(52, 152, 219, 1)',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: balances.map(b => b >= 0 ? 'rgba(39, 174, 96, 1)' : 'rgba(231, 76, 60, 1)'),
                    pointBorderColor: 'white',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y;
                                return 'Balance: ₡' + value.toLocaleString('es-CR', {minimumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return '₡' + value.toLocaleString('es-CR');
                            }
                        },
                        grid: {
                            color: function(context) {
                                if (context.tick.value === 0) {
                                    return 'rgba(0, 0, 0, 0.3)';
                                }
                                return 'rgba(0, 0, 0, 0.1)';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
