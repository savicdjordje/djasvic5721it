<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";
$title = "Novi tip usluge";
include "../../admin-modules/header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naziv = trim($_POST['naziv']);
    $opis = trim($_POST['opis']);
    $error = "";

    if ($naziv == '') {
        $error = "Naziv je obavezan.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO tip_usluge (naziv, opis) VALUES (?, ?)");
        $stmt->execute([$naziv, $opis]);
        header("Location: list.php");
        exit;
    }
}
?>

<div class="container mt-5" style="max-width: 600px;">
    <h2>Dodaj novi tip usluge</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="naziv" class="form-label">Naziv</label>
            <input type="text" name="naziv" id="naziv" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="opis" class="form-label">Opis</label>
            <textarea name="opis" id="opis" class="form-control tinymce" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Sačuvaj</button>
        <a href="index.php" class="btn btn-secondary">Otkaži</a>
    </form>
</div>

<?php include "../../admin-modules/footer.php"; ?>
