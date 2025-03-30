<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";
$title = "Detalji rezervacije";
include "../../admin-modules/header.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID nije prosleđen ili nije validan.</div>";
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT r.*, u.naziv AS usluga_naziv, u.cena
    FROM rezervacije r
    LEFT JOIN usluga u ON r.usluga_id = u.id
    WHERE r.id = ?
");
$stmt->execute([$id]);
$rezervacija = $stmt->fetch();

if (!$rezervacija) {
    echo "<div class='alert alert-warning'>Rezervacija nije pronađena.</div>";
    exit;
}
?>

<div class="container mt-5" style="max-width: 800px;">
    <h2>Detalji rezervacije</h2>

    <dl class="row mt-4">
        <dt class="col-sm-4">Ime i prezime</dt>
        <dd class="col-sm-8"><?= $rezervacija['ime_prezime'] ?></dd>

        <dt class="col-sm-4">Email</dt>
        <dd class="col-sm-8"><?= $rezervacija['email'] ?></dd>

        <dt class="col-sm-4">Usluga</dt>
        <dd class="col-sm-8"><?= $rezervacija['usluga_naziv'] ?> (<?= $rezervacija['cena'] ?> RSD)</dd>

        <dt class="col-sm-4">Marka / Model</dt>
        <dd class="col-sm-8"><?= $rezervacija['marka_auta'] ?> / <?= $rezervacija['model_auta'] ?></dd>

        <dt class="col-sm-4">Registracija</dt>
        <dd class="col-sm-8"><?= $rezervacija['registracija_auta'] ?></dd>

        <dt class="col-sm-4">Dodatni opis</dt>
        <dd class="col-sm-8"><?= $rezervacija['dodatni_opis'] ?></dd>

        <dt class="col-sm-4">Datum i vreme</dt>
        <dd class="col-sm-8"><?= $rezervacija['datum_vreme'] ?></dd>

        <dt class="col-sm-4">Odobreno</dt>
        <dd class="col-sm-8"><?= $rezervacija['odobreno'] ? 'DA' : 'NE' ?></dd>
    </dl>

    <a href="list.php" class="btn btn-secondary mt-3">Nazad na listu</a>
</div>

<?php include "../../admin-modules/footer.php"; ?>
