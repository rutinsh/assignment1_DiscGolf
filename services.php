<?php
session_start();
require_once 'classes/Service.php';

$service = new Service();
$services = [];
$search_keyword = '';

// Handle search
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $search_keyword = trim($_POST['search']);
    $services = $service->search($search_keyword);
} else {
    $services = $service->readAll();
}
?>
<!DOCTYPE html>
<html lang="lv" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ko mēs piedāvājam – SDK Palsa</title>
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Sākums</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Par mums</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="services.php">Ko mēs piedāvājam</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Kontakti</a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="bi bi-speedometer2"></i> Pārvaldības panelis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="bi bi-door-left"></i> Izlogoties
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <i class="bi bi-box-arrow-in-right"></i> Pieslēgties
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">
                            <i class="bi bi-person-plus"></i> Reģistrēties
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <button class="btn btn-sm btn-dark ms-2" id="themeToggle">
                        <i class="bi bi-moon"></i> Dark Mode
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="flex-fill">

<section class="my-5">
    <div class="container">
        <h1>Ko mēs piedāvājam</h1>
        <p class="text-muted">Iepazīstieties ar mūsu pakalpojumiem</p>
    </div>
</section>

<section class="my-5">
    <div class="container">
        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-12">
                <div style="display: flex; gap: 10px; width: 100%;">
                    <form method="POST" style="display: flex; gap: 10px; flex: 1; width: 100%;">
                        <input 
                            type="text" 
                            placeholder="Meklēt pakalpojumus..." 
                            name="search"
                            value="<?php echo htmlspecialchars($search_keyword); ?>"
                            style="flex: 1; height: 70px; padding: 15px 20px; font-size: 20px; border: 4px solid #0047ab; border-radius: 8px; background-color: #ffffff; color: #000; font-weight: 500;"
                        >
                        <button type="submit" style="height: 70px; padding: 0 30px; font-size: 18px; font-weight: 600; border: 4px solid #0047ab; border-radius: 8px; background-color: #0047ab; color: white; cursor: pointer; white-space: nowrap;">
                            <i class="bi bi-search"></i> Meklēt
                        </button>
                        <?php if ($search_keyword): ?>
                            <a href="services.php" style="display: inline-flex; align-items: center; height: 70px; padding: 0 25px; font-size: 16px; font-weight: 600; border: 4px solid #6c757d; border-radius: 8px; background-color: #6c757d; color: white; text-decoration: none;">
                                <i class="bi bi-arrow-counterclockwise"></i> Nodzēst
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <!-- Services Display -->
        <?php if (empty($services)): ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> 
                <?php echo $search_keyword ? 'Meklēšanas rezultātu nav atrasti.' : 'Pakalpojumi vēl nav pievienoti.'; ?>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($services as $svc): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <?php if ($svc['image']): ?>
                                <img src="<?php echo htmlspecialchars($svc['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($svc['title']); ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px; color: white;">
                                    <i class="bi bi-image" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($svc['title']); ?></h5>
                                <p class="card-text flex-grow-1">
                                    <?php echo htmlspecialchars(substr($svc['description'], 0, 100)); ?>
                                    <?php if (strlen($svc['description']) > 100): ?>...<?php endif; ?>
                                </p>
                                <small class="text-muted d-block mb-2">
                                    <i class="bi bi-calendar"></i> 
                                    <?php echo date('Y-m-d', strtotime($svc['created_at'])); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>


