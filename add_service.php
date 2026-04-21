<?php
session_start();
require_once 'classes/Service.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');

    if (empty($title) || empty($description)) {
        $error = 'Nosaukums un apraksts ir obligāti';
    } else {
        $service = new Service();
        try {
            $service->create($title, $description, $image);
            $success = 'Pakalpojums sekmīgi pievienots!';
            // Redirect after 1.5 seconds
            header('Refresh: 1.5; url=dashboard.php');
        } catch (Exception $e) {
            $error = 'Kļūda: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="lv" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pievienot pakalpojumu – SDK Palsa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid px-3">
        <a class="navbar-brand" href="index.php">
            <img src="images/logo.jpg" alt="SDK Palsa logo" height="60" class="d-inline-block align-text-center">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Pārvaldības panelis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Izlogoties</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="flex-fill">
    <section class="my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2>Pievienot jaunu pakalpojumu</h2>

                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($success); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="card card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Pakalpojuma nosaukums*</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Apraksts*</label>
                            <textarea class="form-control" id="description" name="description" rows="6" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Attēla URL</label>
                            <input type="text" class="form-control" id="image" name="image" placeholder="https://example.com/image.jpg">
                        </div>

                        <div>
                            <button type="submit" class="btn btn-success">Pievienot pakalpojumu</button>
                            <a href="dashboard.php" class="btn btn-secondary">Atcelt</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
