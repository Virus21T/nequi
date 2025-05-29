<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nequi - Tu Billetera Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --nequi-pink: #DA0081;
            --nequi-light-pink: #E366A7;
            --nequi-blue: #5A9EFB;
            --nequi-light-blue: #4A8EEB;
            --nequi-orange: #DC410F;
            --nequi-dark: #200020;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--nequi-pink) 0%, var(--nequi-light-pink) 100%);
            color: white;
            padding: 100px 0;
        }

        .feature-card {
            border: none;
            border-radius: 20px;
            transition: transform 0.3s;
            box-shadow: 0 4px 15px rgba(32, 0, 32, 0.1);
            border: 1px solid rgba(218, 0, 129, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(218, 0, 129, 0.2);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--nequi-pink), var(--nequi-light-pink), var(--nequi-pink));
        }

        .btn-primary {
            background-color: var(--nequi-pink);
            border-color: var(--nequi-pink);
        }

        .btn-primary:hover {
            background-color: var(--nequi-light-pink);
            border-color: var(--nequi-light-pink);
        }

        .navbar {
            background-color: var(--nequi-dark) !important;
        }

        .navbar-brand {
            color: var(--nequi-pink) !important;
            font-weight: 700;
        }

        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            color: var(--nequi-light-pink) !important;
        }

        footer {
            background-color: var(--nequi-dark) !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Nequi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Registrarse</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 mb-4">Tu Billetera Digital</h1>
            <p class="lead mb-5">Realiza transacciones, recargas y envíos de dinero de manera segura y rápida</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="login.php" class="btn btn-light btn-lg">Iniciar Sesión</a>
                <a href="register.php" class="btn btn-outline-light btn-lg">Registrarse</a>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5" style="color: var(--nequi-dark);">Nuestros Servicios</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <h3 class="h5 mb-3" style="color: var(--nequi-pink);">Envíos de Dinero</h3>
                            <p style="color: var(--nequi-dark);">Envía dinero de forma segura y rápida a cualquier parte del país</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <h3 class="h5 mb-3" style="color: var(--nequi-pink);">Recargas</h3>
                            <p style="color: var(--nequi-dark);">Recarga tu saldo fácilmente desde cualquier dispositivo</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <h3 class="h5 mb-3" style="color: var(--nequi-pink);">Transacciones</h3>
                            <p style="color: var(--nequi-dark);">Consulta tu historial de transacciones en tiempo real</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4">
        <div class="container text-center">
            <p class="mb-0 text-light"></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
