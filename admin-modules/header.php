<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Admin panel' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/berdhqjm38691anuvyfcfqnv6ot5omob7v4co8gwldt3cpjt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/djasvic5721it/admin/index.php">Admin panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarAdmin">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/djasvic5721it/admin/tipovi_usluge/list.php">Tipovi usluge</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/djasvic5721it/admin/usluge/list.php">Usluge</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/djasvic5721it/admin/rezervacije/list.php">Rezervacije</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/djasvic5721it/admin/index.php">Grafikon</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/djasvic5721it/admin/autorizacija/logout.php">Odjava</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/djasvic5721it/admin/autorizacija/login.php">Prijava</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/djasvic5721it/admin/autorizacija/register.php">Registracija</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container my-5">
