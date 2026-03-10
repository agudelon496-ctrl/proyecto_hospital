<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte HTML</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/sweetalert2.min.css">
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
        .report-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 1000px;
            margin: 40px auto;
        }
        .report-header {
            text-align: center;
            border-bottom: 3px solid #667eea;
            margin-bottom: 30px;
            padding-bottom: 20px;
        }
        .hospital-name {
            color: rgba(52, 58, 64, 0.8);
            font-size: 2.5em;
            font-weight: 700;
            margin: 0;
        }
        .hospital-subtitle {
            color: #666;
            font-size: 1em;
            margin-top: 5px;
        }
        .report-title {
            color: #333;
            font-size: 1.8em;
            font-weight: 600;
            margin: 20px 0 10px 0;
        }
        .report-date {
            color: #999;
            font-size: 0.95em;
            margin-bottom: 20px;
        }
        .print-button {
            background-color: rgba(52, 58, 64, 0.9);
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 1.1em;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 30px;
            transition: 0.3s;
        }
        .print-button:hover {
            background-color: rgba(52, 58, 64, 1);
            box-shadow: 0 4px 12px rgba(52, 58, 64, 0.3);
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table thead {
            background-color: rgba(52, 58, 64, 0.9);
            color: white;
        }
        .table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }
        .table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        .table tbody tr:hover {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            font-weight: 600;
        }
        .badge-disponible {
            background-color: #28a745;
        }
        .badge-ocupada {
            background-color: #ffc107;
            color: black;
        }
        .badge-mantenimiento {
            background-color: #dc3545;
        }

        /* Estilos para impresión */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .navbar, .print-button {
                display: none;
            }
            .report-container {
                box-shadow: none;
                margin: 0;
                padding: 20px;
            }
            .table {
                border: 1px solid #333;
            }
            .table th, .table td {
                border: 1px solid #333;
            }
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

// Datos de camas (en producción vendrían de la BD)
$camas = array(
    array('id' => 1, 'numero' => '101', 'paciente' => 'Juan Pérez', 'edad' => 45, 'estado' => 'ocupada', 'diagnostico' => 'Fractura de pierna'),
    array('id' => 2, 'numero' => '102', 'paciente' => 'María García', 'edad' => 32, 'estado' => 'disponible', 'diagnostico' => ''),
    array('id' => 3, 'numero' => '103', 'paciente' => 'Carlos López', 'edad' => 58, 'estado' => 'ocupada', 'diagnostico' => 'Neumonía'),
    array('id' => 4, 'numero' => '104', 'paciente' => 'Ana Rodríguez', 'edad' => 41, 'estado' => 'ocupada', 'diagnostico' => 'Post-operatorio'),
    array('id' => 5, 'numero' => '105', 'paciente' => '', 'edad' => 0, 'estado' => 'disponible', 'diagnostico' => ''),
    array('id' => 6, 'numero' => '106', 'paciente' => 'Roberto Sánchez', 'edad' => 72, 'estado' => 'ocupada', 'diagnostico' => 'Infarto'),
);

$fecha_reporte = date('d/m/Y H:i');
$total_camas = count($camas);
$camas_ocupadas = count(array_filter($camas, function($c) { return $c['estado'] == 'ocupada'; }));
$camas_disponibles = count(array_filter($camas, function($c) { return $c['estado'] == 'disponible'; }));
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

<!-- REPORTE -->
<div class="report-container">
    
    <!-- Encabezado del Reporte -->
    <div class="report-header">
        <h1 class="hospital-name">🏥 HOSPITAL</h1>
        <p class="hospital-subtitle">Sistema de Gestión de Camas - Reporte Oficial</p>
    </div>

    <!-- Botón de Impresión -->
    <button class="print-button" onclick="imprimirReporte()">🖨️ Imprimir Reporte</button>

    <!-- Información del Reporte -->
    <h2 class="report-title">Reporte General de Camas</h2>
    <p class="report-date">
        📅 Fecha de Reporte: <strong><?php echo $fecha_reporte; ?></strong>
    </p>

    <!-- Estadísticas Rápidas -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 30px;">
        <div style="background: #f0f4ff; padding: 15px; border-radius: 8px; text-align: center;">
            <div style="font-size: 2em; color: #667eea; font-weight: bold;"><?php echo $total_camas; ?></div>
            <div style="color: #666;">Total de Camas</div>
        </div>
        <div style="background: #fff4e6; padding: 15px; border-radius: 8px; text-align: center;">
            <div style="font-size: 2em; color: #ffc107; font-weight: bold;"><?php echo $camas_ocupadas; ?></div>
            <div style="color: #666;">Camas Ocupadas</div>
        </div>
        <div style="background: #e6f7ff; padding: 15px; border-radius: 8px; text-align: center;">
            <div style="font-size: 2em; color: #28a745; font-weight: bold;"><?php echo $camas_disponibles; ?></div>
            <div style="color: #666;">Camas Disponibles</div>
        </div>
    </div>

    <!-- Tabla de Camas -->
    <table class="table">
        <thead>
            <tr>
                <th>Cama #</th>
                <th>Paciente</th>
                <th>Edad</th>
                <th>Estado</th>
                <th>Diagnóstico</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($camas as $cama): ?>
            <tr>
                <td><strong><?php echo $cama['numero']; ?></strong></td>
                <td><?php echo $cama['paciente'] ?: '—'; ?></td>
                <td><?php echo $cama['edad'] ?: '—'; ?></td>
                <td>
                    <span class="badge badge-<?php echo $cama['estado']; ?>">
                        <?php 
                            $estados = array('disponible' => '✓ Disponible', 'ocupada' => '👤 Ocupada', 'mantenimiento' => '🔧 Mantenimiento');
                            echo $estados[$cama['estado']];
                        ?>
                    </span>
                </td>
                <td><?php echo $cama['diagnostico'] ?: '—'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pie del Reporte -->
    <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center; color: #999;">
        <p style="font-size: 0.9em;">Reporte generado por: <strong><?php echo $_SESSION['usuario']; ?></strong></p>
        <p style="font-size: 0.85em; color: #bbb;">Sistema de Gestión Hospitalaria © 2026</p>
    </div>
</div>

<script src="../js/jquery-4.0.0.min.js"></script>
<script src="../js/sweetalert2.all.min.js"></script>
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

    // Función para imprimir el reporte
    function imprimirReporte() {
        Swal.fire({
            icon: 'info',
            title: 'Preparando impresión...',
            text: 'Se abrirá la ventana de impresión de tu navegador',
            confirmButtonColor: '#667eea',
            didOpen: () => {
                window.print();
            }
        });
    }
</script>

</body>
</html>