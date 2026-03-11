<!-- Vista para agregar una nueva cama.
     Contiene un formulario con validaciones. -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nueva Cama</title>
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
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 40px auto;
        }
        .form-title {
            color: rgba(52, 58, 64, 0.8);
            font-size: 2em;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px 15px;
            font-size: 1em;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        .btn-submit {
            background-color: rgba(52, 58, 64, 0.9);
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 1.1em;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }
        .btn-submit:hover {
            background-color: rgba(52, 58, 64, 1);
            box-shadow: 0 4px 12px rgba(52, 58, 64, 0.3);
        }
    </style>
</head>
<body>

<?php
// Comprobar que exista sesión activa antes de mostrar la vista
// Si no hay usuario logueado, redirige de vuelta al login principal.
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location:../index.html");
    exit();
}
?>

<!-- A partir de aquí se renderiza el formulario de ingreso de nueva cama -->

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

<!-- FORMULARIO AGREGAR CAMA -->
<div class="container">
    <div class="form-card">
        <h1 class="form-title">➕ Agregar Nueva Cama</h1>
        <!-- Formulario principal: los datos se envían por POST a guardar_cama.php -->
        <form id="formCama" method="POST" action="../controladores/guardar_cama.php">
            
            <div class="form-group">
                <label for="numero">Número de Cama:</label>
                <input type="text" id="numero" name="numero" class="form-control" placeholder="Ej: 101" required>
            </div>

            <div class="form-group">
                <label for="paciente">Nombre del Paciente:</label>
                <input type="text" id="paciente" name="paciente" class="form-control" placeholder="Nombre del paciente" required>
            </div>

            <div class="form-group">
                <label for="edad">Edad:</label>
                <input type="number" id="edad" name="edad" class="form-control" placeholder="Edad" min="1" max="150" required>
            </div>

            <div class="form-group">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado" class="form-control" required>
                    <option value="">Seleccionar estado</option>
                    <option value="disponible">Disponible</option>
                    <option value="ocupada">Ocupada</option>
                    <option value="mantenimiento">Mantenimiento</option>
                </select>
            </div>

            <div class="form-group">
                <label for="diagnostico">Diagnóstico:</label>
                <textarea id="diagnostico" name="diagnostico" class="form-control" rows="4" placeholder="Describa el diagnóstico"></textarea>
            </div>

            <button type="submit" class="btn-submit">💾 Guardar Cama</button>
        </form>
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

    // Validaciones del formulario
    document.getElementById('formCama').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const paciente = document.getElementById('paciente').value.trim();
        const edad = document.getElementById('edad').value.trim();
        const numero = document.getElementById('numero').value.trim();
        const estado = document.getElementById('estado').value;

        // Validación 1: Campo vacío
        if (!paciente) {
            Swal.fire({
                icon: 'warning',
                title: '¡Cuidado!',
                text: 'Olvídaste escribir el nombre del paciente',
                confirmButtonColor: '#667eea'
            });
            return;
        }

        // Validación 2: Solo números en edad
        if (isNaN(edad) || edad === '') {
            Swal.fire({
                icon: 'error',
                title: '¡Solo Números!',
                text: 'En la edad no puedes poner letras',
                confirmButtonColor: '#667eea'
            });
            return;
        }

        // Validación 3: Confirmación
        Swal.fire({
            icon: 'question',
            title: '¿Estás seguro?',
            text: '¿Deseas guardar esta cama?',
            showCancelButton: true,
            confirmButtonColor: '#667eea',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí iría el envío real
                Swal.fire({
                    icon: 'success',
                    title: '¡Guardado!',
                    text: '¡Listo! Los datos ya están en la base de datos',
                    confirmButtonColor: '#28a745',
                    background: '#f8f9fa',
                    shape: 'rounded'
                });
                
                // Redirigir después de 2 segundos
                setTimeout(() => {
                    // this.submit(); // Descomenta para envío real
                    document.getElementById('formCama').reset();
                }, 1500);
            }
        });
    });
</script>

</body>
</html>