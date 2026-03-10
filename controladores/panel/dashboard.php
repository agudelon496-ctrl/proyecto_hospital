<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Hospital - Sistema de Camas</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
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
        .dropdown-item:hover {
            background-color: rgba(108, 117, 125, 0.8);
        }
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .welcome-text {
            color: rgba(52, 58, 64, 0.8);
            font-size: 1.5em;
            font-weight: 600;
        }
    </style>
</head>
<body>

<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location:../../index.html");
    exit();
}
?>

<!-- NAVBAR DE NAVEGACIÓN -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">🏥 Hospital - Sistema Camas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                
                <!-- Inicio -->
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">🏠 Inicio</a>
                </li>

                <!-- Gestión (Dropdown) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarGestion" role="button" data-bs-toggle="dropdown">
                        📋 Gestión
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarGestion">
                        <li><a class="dropdown-item" href="../../vistas/agregar_cama.php">➕ Agregar Nuevo</a></li>
                        <li><a class="dropdown-item" href="../../vistas/listar_camas.php">📋 Ver Listado</a></li>
                    </ul>
                </li>

                <!-- Análisis -->
                <li class="nav-item">
                    <a class="nav-link" href="../../vistas/analisis.php">📊 Análisis</a>
                </li>

                <!-- Documentos (Dropdown) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDoc" role="button" data-bs-toggle="dropdown">
                        📁 Documentos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDoc">
                        <li><a class="dropdown-item" href="../../vistas/reporte.php">📄 Reporte HTML</a></li>
                        <li><a class="dropdown-item" href="../../vistas/reporte.php?pdf=1">⬇️ Descargar PDF</a></li>
                    </ul>
                </li>

                <!-- Cerrar Sesión -->
                <li class="nav-item">
                    <a class="nav-link" href="../../controladores/logout.php" style="color: #ff6b6b;">🚪 Salir</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- CONTENIDO PRINCIPAL -->
<div class="container">
    <div class="welcome-card">
        <p class="welcome-text">¡Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong>! 👋</p>
        <p style="color: #666; margin-top: 10px;">Selecciona una opción del menú para continuar.</p>
    </div>
</div>

<script src="../../js/jquery-4.0.0.min.js"></script>
<script src="../../js/sweetalert2.all.min.js"></script>
<script>
    // Dropdown menus - Vanilla JS
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
</script>

</body>
</html>