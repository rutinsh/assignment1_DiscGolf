<?php
session_start();
require_once 'classes/Database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Server-side validation
    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Visi lauki ir obligāti';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Nepareizs e-pasta formāts';
    } elseif (strlen($message) < 10) {
        $error = 'Ziņojums jābūt vismaz 10 rakstzīmes garš';
    } else {
        try {
            $db = new Database();
            $pdo = $db->getPDO();
            
            $stmt = $pdo->prepare('INSERT INTO messages (name, email, message) VALUES (?, ?, ?)');
            $stmt->execute([$name, $email, $message]);
            
            $success = 'Ziņojums sekmīgi nosūtīts! Paldies par saikni.';
        } catch (Exception $e) {
            $error = 'Kļūda ziņojuma nosūtīšanā: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="lv" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakti – SDK Palsa</title>
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
                    <a class="nav-link" href="services.php">Ko mēs piedāvājam</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="contact.php">Kontakti</a>
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
        <h1>Kontakti</h1>
    </div>
</section>

<section class="my-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-building"></i> SDK Palsa</h5>
                        <p class="card-text">
                            <i class="bi bi-geo-alt"></i> Palsmane, Smiltenes novads<br>
                            <i class="bi bi-envelope"></i> sdk.palsa@gmail.com<br>
                            <i class="bi bi-telephone"></i> +371 29198755
                        </p>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-share"></i> Sociālie tīkli</h5>
                        <p class="card-text">
                            Facebook: <strong>SDK Palsa</strong>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <h5>Karte</h5>
                <iframe 
                    src="https://www.google.com/maps?q=Palsmane&output=embed"
                    width="100%" 
                    height="300" 
                    style="border:0; border-radius: 8px;"
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</section>

<section class="my-5">
    <div class="container">
        <h2>Pievienošanās klubam</h2>
        <p>Aizpildiet kontaktformu vai rakstiet e-pastu, lai:</p>
        <ul>
            <li>pievienotos treniņiem</li>
            <li>kļūtu par kluba biedru</li>
            <li>pieteiktu pasākumu</li>
        </ul>
    </div>
</section>

<section class="my-5">
    <div class="container">
        <h2>Kontaktforma</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form id="contactForm" class="mt-4" method="POST" style="max-width: 600px;">
            <div class="mb-3">
                <label for="name" class="form-label">Vārds, Uzvārds*</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="name" 
                    name="name" 
                    placeholder="Vārds, Uzvārds" 
                    required
                >
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-pasts*</label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    name="email" 
                    placeholder="E-pasts" 
                    required
                >
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Ziņojums*</label>
                <textarea 
                    class="form-control" 
                    id="message" 
                    name="message" 
                    rows="5" 
                    placeholder="Ziņojums" 
                    required
                ></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Nosūtīt</button>
        </form>
    </div>
</section>

</main>

<footer class="bg-primary text-white text-center py-4 mt-auto">
    <p class="mb-0">© <span id="year">2026</span> SDK Palsa</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>
