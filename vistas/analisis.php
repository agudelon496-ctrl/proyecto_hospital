<!-- Página de análisis de camas con gráficos generados por Chart.js.
     Requiere sesión activa. -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body {
            padding-top: 60px;
            background-color: #f5f5f5;
        }
        .navbar {
            background-color: rgba(52, 58, 64, 0.9);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.3em;
        }
        .nav-link {
            margin: 0 5px;
            transition: 0.3s;
        }
        .nav-link:hover {
            background-color: rgba(255,255,255,0.2);
            border-radius: 4px;
        }
        .dropdown-menu {
            background-color: rgba(52, 58, 64, 0.95);
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 200px;
            z-index: 1000;
        }
        .dropdown-menu.show {
            display: block;
        }
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }
        .analytics-container {
            margin: 40px auto;
            padding: 20px;
        }
        .chart-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .chart-title {
            color: rgba(52, 58, 64, 0.8);
            font-size: 1.5em;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .page-title {
            color: rgba(52, 58, 64, 0.8);
            font-size: 2em;
            font-weight: 600;
            text-align: center;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location:../index.html");
    exit();
}
?>

<!-- NAVBAR DE NAVEGACIÓN -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">🏥 Hospital - Sistema Camas</a>
        <button class="navbar-toggler" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../controladores/panel/dashboard.php">🏠 Inicio</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#">📋 Gestión</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="agregar_cama.php">➕ Agregar Nuevo</a></li>
                        <li><a class="dropdown-item" href="listar_camas.php">📋 Ver Listado</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="analisis.php">📊 Análisis</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#">📁 Documentos</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="reporte.php">📄 Reporte HTML</a></li>
                        <li><a class="dropdown-item" href="reporte.php?pdf=1">⬇️ Descargar PDF</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../controladores/logout.php" style="color: #ff6b6b;">🚪 Salir</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- GRÁFICOS -->
<div class="analytics-container">
    <h1 class="page-title">📊 Análisis de Camas</h1>
    
    <div class="charts-grid">
        
        <!-- Gráfico 1: Estado de Camas (Pie) -->
        <div class="chart-card">
            <h2 class="chart-title">Estado de Camas</h2>
            <canvas id="chart1"></canvas>
        </div>

        <!-- Gráfico 2: Ocupación por Piso (Bar) -->
        <div class="chart-card">
            <h2 class="chart-title">Ocupación por Piso</h2>
            <canvas id="chart2"></canvas>
        </div>

        <!-- Gráfico 3: Diagnósticos Comunes (Doughnut) -->
        <div class="chart-card">
            <h2 class="chart-title">Diagnósticos Más Frecuentes</h2>
            <canvas id="chart3"></canvas>
        </div>
    </div>
</div>

<script src="../js/jquery-4.0.0.min.js"></script>
<script src="../js/chart.min.js"></script>
<script>
    // Dropdown menus
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const menu = this.nextElementSibling;
            menu.classList.toggle('show');
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                if (m !== menu) m.classList.remove('show');
            });
        });
    });
    
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(m => {
                m.classList.remove('show');
            });
        }
    });

    // Chart.js - Gráfico 1: Estado de Camas (Pie/Dona)
    // Datos codificados; reemplazar por variables dinámicas según BD
    const ctx1 = document.getElementById('chart1').getContext('2d');
    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Disponibles', 'Ocupadas', 'Mantenimiento'],
            datasets: [{
                data: [8, 15, 2],
                backgroundColor: [
                    '#28a745',  // Verde
                    '#ffc107',  // Amarillo
                    '#dc3545'   // Rojo
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Chart.js - Gráfico 2: Ocupación por Piso (Bar)
    // Cada dataset representa camas ocupadas/disponibles por piso
    const ctx2 = document.getElementById('chart2').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Piso 1', 'Piso 2', 'Piso 3', 'Piso 4'],
            datasets: [{
                label: 'Camas Ocupadas',
                data: [5, 8, 6, 4],
                backgroundColor: '#667eea',
                borderColor: '#667eea',
                borderWidth: 1
            },
            {
                label: 'Camas Disponibles',
                data: [3, 2, 4, 6],
                backgroundColor: '#28a745',
                borderColor: '#28a745',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'x',
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 2
                    }
                }
            }
        }
    });

    // Chart.js - Gráfico 3: Diagnósticos (Pie)
    // Etiquetas de ejemplo; pueden provenir de consulta SQL agregando PHP
    const ctx3 = document.getElementById('chart3').getContext('2d');
    new Chart(ctx3, {
        type: 'pie',
        data: {
            labels: ['Fracturas', 'Problemas Respiratorios', 'Cirugías', 'Otros'],
            datasets: [{
                data: [28, 22, 18, 12],
                backgroundColor: [
                    '#FF6B6B',
                    '#4ECDC4', 
                    '#45B7D1',
                    '#FFA07A'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>

</body>
</html>