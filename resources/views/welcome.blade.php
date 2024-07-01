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
            background: url('https://source.unsplash.com/1600x900/?office,work') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        .navbar {
            background-color: #000;
        }
        .hero-section {
            background-color: rgba(248, 249, 250, 0.8);
            color: #343a40;
            padding: 60px 20px;
            text-align: center;
            border-radius: 10px;
            margin-top: 100px;
            animation: fadeIn 2s;
        }
        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .hero-section p {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }
        .btn-custom {
            margin: 0 10px;
            padding: 15px 30px;
            font-size: 1.25rem;
            border-radius: 50px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-custom-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
        }
        .btn-custom-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .btn-custom-success {
            background-color: #28a745;
            color: #fff;
            border: none;
        }
        .btn-custom-success:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
    </nav>
    @if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <div class="main-content">
        <div class="hero-section">
            <div class="container">
                <h1>Sistem Informasi Penggajian dan Absensi Karyawan</h1>
                <p>Sistem ini dirancang untuk memudahkan pengelolaan penggajian dan absensi karyawan dengan efektif dan efisien.</p>
                <a href="/login" class="btn btn-custom btn-custom-primary">Login</a>
                <a href="/register" class="btn btn-custom btn-custom-success">Register</a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 CV YP Sukses Makmur. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gqzXVst2iQAPvDJXjBfF/yJ2yHYdyhFw4ZQwX0pB8a7zToah4i2zyW+CU27h8v4f" crossorigin="anonymous"></script>
</body>
</html>
