<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";
$title = "Nova usluga";
include "../../admin-modules/header.php";

$tipovi_stmt = $pdo->query("SELECT id, naziv FROM tip_usluge");
$tipovi = $tipovi_stmt->fetchAll();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tip_id = $_POST['tip_usluge_id'];
    $naziv = trim($_POST['naziv']);
    $opis = trim($_POST['opis']);
    $cena = $_POST['cena'];
    $objavljeno = isset($_POST['objavljeno']) ? 1 : 0;
    $istaknuto = isset($_POST['istaknuto']) ? 1 : 0;

    $slika_ime = null;

    if ($naziv === '' || $tip_id === '') {
        $errors[] = "Naziv i tip usluge su obavezni.";
    }

    if (!is_numeric($cena) || $cena < 0) {
        $errors[] = "Cena mora biti validan broj.";
    }

    if (isset($_FILES['slika'])) {
        $ekstenzija = pathinfo($_FILES['slika']['name'], PATHINFO_EXTENSION);
        $slika_ime = 'images/' . uniqid('slika_') . '.' . $ekstenzija;
        move_uploaded_file($_FILES['slika']['tmp_name'], '../../' . $slika_ime);
    }
    

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO usluga (tip_usluge_id, naziv, opis, cena, slika, objavljeno, istaknuto)
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$tip_id, $naziv, $opis, $cena, $slika_ime, $objavljeno, $istaknuto]);

        header("Location: list.php");
        exit;
    }
}
?>

<div class="container mt-5" style="max-width: 700px;">
    <h2>Dodaj novu uslugu</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="tip_usluge_id" class="form-label">Tip usluge</label>
            <select name="tip_usluge_id" id="tip_usluge_id" class="form-select" required>
                <option value="">-- Izaberi tip --</option>
                <?php foreach ($tipovi as $tip): ?>
                    <option value="<?= $tip['id'] ?>"><?= htmlspecialchars($tip['naziv']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="naziv" class="form-label">Naziv</label>
            <input type="text" name="naziv" id="naziv" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="opis" class="form-label">Opis</label>
            <textarea name="opis" id="opis" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label for="cena" class="form-label">Cena (RSD)</label>
            <input type="number" name="cena" id="cena" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="slika" class="form-label">Slika (JPG, PNG, GIF)</label>
            <input type="file" name="slika" id="slika" class="form-control" accept=".jpg,.jpeg,.png,.gif">
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="objavljeno" id="objavljeno" checked>
            <label class="form-check-label" for="objavljeno">Objavljeno</label>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="istaknuto" id="istaknuto">
            <label class="form-check-label" for="istaknuto">Istaknuto</label>
        </div>

        <button type="submit" class="btn btn-success">Sačuvaj</button>
        <a href="list.php" class="btn btn-secondary">Otkaži</a>
    </form>
</div>

<?php include "../../admin-modules/footer.php"; ?>
