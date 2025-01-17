<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi CV YP Sukses Makmur</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://source.unsplash.com/1600x900/?office,work') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .navbar {
            display: flex;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.85);
            padding: 10px 20px;
        }
        .navbar-brand {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
            margin-left: 10px;
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        .hero-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
            background-color: rgba(255, 255, 255, 0.85);
            color: #343a40;
            padding: 60px 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
            max-width: 600px;
        }
        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        .btn-custom {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
            margin: 5px;
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
        }
        .btn-custom-primary {
            background: linear-gradient(135deg, #4A90E2, #357ABD);
        }
        .btn-custom-success {
            background: linear-gradient(135deg, #5CB85C, #4CAF50);
        }
        .btn-custom-primary:hover, .btn-custom-success:hover {
            transform: scale(1.05);
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2);
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.85);
            color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            <img src="foto/logo.png" alt="Logo">
            CV YP Sukses Makmur
        </a>
    </nav>
    
    <!-- Main Content -->
    <div class="hero-section">
        <h1>Sistem Informasi Penggajian dan Absensi Karyawan</h1>
        <p>Sistem ini dirancang untuk memudahkan pengelolaan penggajian dan absensi karyawan dengan efektif dan efisien.</p>
        <a href="/login" class="btn btn-custom btn-custom-primary">Login</a>
        <a href="/register" class="btn btn-custom btn-custom-success">Register</a>
    </div>

    <!-- Footer -->
    <footer>
        <p>2024 UMKM CV YP Sukses Makmur. All rights reserved.</p>
    </footer>
</body>
</html>
