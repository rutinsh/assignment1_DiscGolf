<?php
session_start();
require_once 'classes/Service.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$service = new Service();
$services = $service->readAll();
?>
<!DOCTYPE html>
<html lang="lv" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pārvaldības panelis – SDK Palsa</title>
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
                    <a class="nav-link" href="index.php">Sākums</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="services.php">Ko mēs piedāvājam</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">Pārvaldības panelis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Izlogoties (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="flex-fill">
    <section class="my-5">
        <div class="container">
            <h1>Pārvaldības panelis</h1>
            <p class="text-muted">Sveiki, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

            <div class="mb-4">
                <a href="add_service.php" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Pievienot jaunu pakalpojumu
                </a>
            </div>

            <?php if (empty($services)): ?>
                <div class="alert alert-info">
                    Pakalpojumi nav pievienoti. <a href="add_service.php">Pievienot pirmo pakalpojumu</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nosaukums</th>
                                <th>Apraksts</th>
                                <th>Darbības</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $svc): ?>
                                <tr>
                                    <td><?php echo $svc['id']; ?></td>
                                    <td><?php echo htmlspecialchars($svc['title']); ?></td>
                                    <td><?php echo substr(htmlspecialchars($svc['description']), 0, 50) . '...'; ?></td>
                                    <td>
                                        <a href="edit_service.php?id=<?php echo $svc['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Rediģēt
                                        </a>
                                        <a href="delete_service.php?id=<?php echo $svc['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Ar jūs pārliecināti?')">
                                            <i class="bi bi-trash"></i> Dzēst
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
