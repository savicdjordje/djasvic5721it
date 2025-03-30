<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";
$title = "Izmena usluge";
include "../../admin-modules/header.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID nije prosleđen ili nije validan.</div>";
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM usluga WHERE id = ?");
$stmt->execute([$id]);
$usluga = $stmt->fetch();

if (!$usluga) {
    echo "<div class='alert alert-warning'>Usluga nije pronađena.</div>";
    exit;
}

$tipovi_stmt = $pdo->query("SELECT id, naziv FROM tip_usluge");
$tipovi = $tipovi_stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tip_id = $_POST['tip_usluge_id'];
    $naziv = trim($_POST['naziv']);
    $opis = trim($_POST['opis']);
    $cena = $_POST['cena'];
    $objavljeno = isset($_POST['objavljeno']) ? 1 : 0;
    $istaknuto = isset($_POST['istaknuto']) ? 1 : 0;

    if ($naziv == '' || $tip_id == '') {
        $error = "Naziv i tip usluge su obavezni.";
    }else if (!is_numeric($cena) || $cena < 0) {
        $error = "Cena mora biti validan broj.";
    } else {
        $stmt = $pdo->prepare("UPDATE usluga SET tip_usluge_id = ?, naziv = ?, opis = ?, cena = ?, objavljeno = ?, istaknuto = ? WHERE id = ?");
        $stmt->execute([$tip_id, $naziv, $opis, $cena, $objavljeno, $istaknuto, $id]);

        header("Location: list.php");
        exit;
    }
}
?>

<div class="container mt-5" style="max-width: 700px;">
    <h2>Izmena usluge</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="tip_usluge_id" class="form-label">Tip usluge</label>
            <select name="tip_usluge_id" id="tip_usluge_id" class="form-select" required>
                <option value="">-- Izaberi tip --</option>
                <?php foreach ($tipovi as $tip): ?>
                    <option value="<?= $tip['id'] ?>" <?= $tip['id'] == $usluga['tip_usluge_id'] ? 'selected' : '' ?>>
                        <?= $tip['naziv'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="naziv" class="form-label">Naziv</label>
            <input type="text" name="naziv" id="naziv" class="form-control" value="<?= $usluga['naziv'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="opis" class="form-label">Opis</label>
            <textarea name="opis" id="opis" class="form-control tinymce" rows="4"><?= $usluga['opis'] ?></textarea>
        </div>

        <div class="mb-3">
            <label for="cena" class="form-label">Cena (RSD)</label>
            <input type="number" name="cena" id="cena" class="form-control" step="0.01" value="<?= $usluga['cena'] ?>" required>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="objavljeno" id="objavljeno" <?= $usluga['objavljeno'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="objavljeno">Objavljeno</label>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="istaknuto" id="istaknuto" <?= $usluga['istaknuto'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="istaknuto">Istaknuto</label>
        </div>

        <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
        <a href="list.php" class="btn btn-secondary">Otkaži</a>
    </form>
</div>

<?php include "../../admin-modules/footer.php"; ?>
