<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";
$title = "Izmena tipa usluge";
include "../../admin-modules/header.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID nije prosleđen ili nije validan.</div>";
    exit;
}

$id = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naziv = trim($_POST['naziv']);
    $opis = trim($_POST['opis']);

    if ($naziv == '') {
        $error = "Naziv je obavezan.";
    } else {
        $stmt = $pdo->prepare("UPDATE tip_usluge SET naziv = ?, opis = ? WHERE id = ?");
        $stmt->execute([$naziv, $opis, $id]);
        header("Location: list.php");
        exit;
    }
}

$stmt = $pdo->prepare("SELECT * FROM tip_usluge WHERE id = ?");
$stmt->execute([$id]);
$tip = $stmt->fetch();

if (!$tip) {
    echo "<div class='alert alert-warning'>Tip usluge nije pronađen.</div>";
    exit;
}
?>

<div class="container mt-5" style="max-width: 600px;">
    <h2>Izmena tipa usluge</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="naziv" class="form-label">Naziv</label>
            <input type="text" name="naziv" id="naziv" class="form-control" value="<?= $tip['naziv'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="opis" class="form-label">Opis</label>
            <textarea name="opis" id="opis" class="form-control" rows="5"><?= $tip['opis'] ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
        <a href="list.php" class="btn btn-secondary">Otkaži</a>
    </form>
</div>

<?php include "../../admin-modules/footer.php"; ?>
