<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Camas</title>
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
        .table-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 40px auto;
        }
        .table-title {
            color: rgba(52, 58, 64, 0.8);
            font-size: 2em;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
        }
        .table {
            margin-bottom: 0;
        }
        .table thead {
            background-color: rgba(52, 58, 64, 0.9);
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f5f5f5;
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
        .btn-small {
            padding: 5px 10px;
            font-size: 0.9em;
            margin: 2px;
        }
        .btn-edit {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-edit:hover {
            background-color: #0056b3;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .container {
            max-width: 1000px;
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

// Datos de ejemplo (en producción vendrían de la BD)
$camas = array(
    array('id' => 1, 'numero' => '101', 'paciente' => 'Juan Pérez', 'edad' => 45, 'estado' => 'ocupada', 'diagnostico' => 'Fractura de pierna'),
    array('id' => 2, 'numero' => '102', 'paciente' => 'María García', 'edad' => 32, 'estado' => 'disponible', 'diagnostico' => ''),
    array('id' => 3, 'numero' => '103', 'paciente' => 'Carlos López', 'edad' => 58, 'estado' => 'ocupada', 'diagnostico' => 'Neumonía'),
    array('id' => 4, 'numero' => '104', 'paciente' => '', 'edad' => 0, 'estado' => 'mantenimiento', 'diagnostico' => 'En revisión'),
);
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

<!-- TABLA DE CAMAS -->
<div class="container">
    <div class="table-card">
        <h1 class="table-title">📋 Listado de Camas</h1>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Cama #</th>
                        <th>Paciente</th>
                        <th>Edad</th>
                        <th>Estado</th>
                        <th>Diagnóstico</th>
                        <th>Acciones</th>
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
                        <td>
                            <button class="btn-small btn-edit" onclick="editarCama(<?php echo $cama['id']; ?>)">✏️ Editar</button>
                            <button class="btn-small btn-delete" onclick="eliminarCama(<?php echo $cama['id']; ?>)">🗑️ Borrar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
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

    // Función editar cama
    function editarCama(id) {
        Swal.fire({
            icon: 'info',
            title: 'Editar Cama',
            text: 'Función de edición en desarrollo',
            confirmButtonColor: '#667eea'
        });
    }

    // Función eliminar cama
    function eliminarCama(id) {
        Swal.fire({
            icon: 'warning',
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar esta cama? Esta acción no se puede deshacer.',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Eliminada!',
                    text: 'La cama ha sido eliminada correctamente',
                    confirmButtonColor: '#28a745'
                });
            }
        });
    }
</script>

</body>
</html>