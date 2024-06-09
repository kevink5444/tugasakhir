<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Penggajian dan Absensi Karyawan CV YP Sukses Makmur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-kWu3wGbuRl5rKvxV3H3kOu0E2Bp1Tt2fKZr3EJoNvChvU1N0J1y23iigw4jPSJ5b" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #fff;
            display: block;
        }
        .sidebar a:hover {
            background-color: #007bff;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .hero-section {
            background-color: #f8f9fa;
            color: #343a40;
            padding: 60px 20px;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 30px;
        }
        .btn-custom {
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistem Informasi Penggajian dan Absensi Karyawan CV YP Sukses Makmur</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <a href="#">Dashboard</a>
        <a href="#">Penggajian</a>
        <a href="#">Absensi</a>
        <a href="#">Laporan</a>
        <a href="#">Pengaturan</a>
    </div>

    <div class="main-content">
        <div class="hero-section">
            <div class="container">
                <h1>Welcome to Sistem Informasi Penggajian dan Absensi Karyawan CV YP Sukses Makmur</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse scelerisque at diam at dapibus.</p>
                <a href="/login" class="btn btn-primary btn-lg btn-custom">Login</a>
                <a href="/register" class="btn btn-success btn-lg btn-custom">Register</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gqzXVst2iQAPvDJXjBfF/yJ2yHYdyhFw4ZQwX0pB8a7zToah4i2zyW+CU27h8v4f" crossorigin="anonymous"></script>
</body>
</html>
