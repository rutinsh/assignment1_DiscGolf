<?php
session_start();
require_once 'classes/Service.php';

// Handle welcome message
$welcome_message = '';
if (isset($_COOKIE['username']) && isset($_COOKIE['last_visit'])) {
    $welcome_message = "Sveiki atpakaļ, " . htmlspecialchars($_COOKIE['username']) . "! Pēdējā apmeklēšana: " . htmlspecialchars($_COOKIE['last_visit']);
}

// Update last visit on page load
if (isset($_SESSION['user_id'])) {
    setcookie('last_visit', date('Y-m-d H:i:s'), time() + (365 * 24 * 60 * 60), '/');
}
?>
<!DOCTYPE html>
<html lang="lv" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDK Palsa – Sākumlapa</title>
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
                    <a class="nav-link active" aria-current="page" href="index.php">Sākums</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Par mums</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="services.php">Ko mēs piedāvājam</a>
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

<?php if ($welcome_message): ?>
    <div class="container mt-3">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle"></i> <?php echo $welcome_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php elseif (isset($_SESSION['user_id'])): ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> Sveiki, <?php echo htmlspecialchars($_SESSION['username']); ?>!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<header class="hero">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-8 text-center">
                <h1>SDK Palsa – disku golfs Smiltenes novadā</h1>
                <p class="lead">Aktīva diskgolfa kopiena ar savu laukumu Palsmanē. Treniņi, sacensības un sportiska atmosfēra visiem līmeņiem.</p>
                <div class="hero-buttons">
                    <a href="register.php" class="btn btn-light btn-lg">Pievienojies mums</a>
                    <a href="services.php" class="btn btn-outline-light btn-lg">Skaties pakalpojumus</a>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="featured my-5">
    <div class="container">
        <h2>Par mums</h2>
        <p class="fw-bold">
            SDK Palsa ir disku golfa klubs Palsmanē, kas apvieno amatierus, juniorus un pieredzējušus spēlētājus.
            Mēs organizējam turnīrus, trenējamies kopā un attīstām disku golfu Smiltenes novadā.
        </p>
    </div>
</section>

<section class="features my-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="feature-box">
                    <h3>Jaunumi</h3>
                    <ul>
                        <li>Palsas kauss (PDGA C-tier)</li>
                        <li>Latvijas čempionāta medaļas (MJ15, MJ18, FP50)</li>
                        <li>Regulārie līgas vakari Palsas trasē</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="feature-box">
                    <h3>Ātrās saites</h3>
                    <ul>
                        <li><a href="about.php">Par klubu</a></li>
                        <li><a href="services.php">Treniņu laiki</a></li>
                        <li><a href="services.php">Sacensības</a></li>
                        <li><a href="contact.php">Kontakti</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
