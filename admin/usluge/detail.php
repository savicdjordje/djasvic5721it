<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";
$title = "Detalji o usluzi";
include "../../admin-modules/header.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID nije prosleđen ili nije validan.</div>";
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT u.*, tu.naziv AS tip_naziv
    FROM usluga u
    LEFT JOIN tip_usluge tu ON u.tip_usluge_id = tu.id
    WHERE u.id = ?
");
$stmt->execute([$id]);
$usluga = $stmt->fetch();

if (!$usluga) {
    echo "<div class='alert alert-warning'>Usluga nije pronađena.</div>";
    exit;
}
?>

<div class="container mt-5" style="max-width: 700px;">
    <h2><?= $usluga['naziv'] ?></h2>

    <p><strong>Tip usluge:</strong> <?= $usluga['tip_naziv'] ?></p>
    <p><strong>Opis:</strong><br><?= nl2br($usluga['opis']) ?></p>
    <p><strong>Cena:</strong> <?= $usluga['cena'] ?> RSD</p>

    <a href="list.php" class="btn btn-secondary mt-3">Nazad na listu</a>
</div>

<?php include "../../admin-modules/footer.php"; ?>
