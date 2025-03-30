<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";
$title = "Detalji o tipu usluge";
include "../../admin-modules/header.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID nije prosleđen ili nije validan.</div>";
    exit;
}

$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tip_usluge WHERE id = ?");
$stmt->execute([$id]);
$tip = $stmt->fetch();

if (!$tip) {
    echo "<div class='alert alert-warning'>Tip usluge nije pronađen.</div>";
    exit;
}
?>

<div class="container mt-5" style="max-width: 600px;">
    <h2><?= $tip['naziv'] ?></h2>
    <p><?= nl2br($tip['opis']) ?></p>

    <a href="list.php" class="btn btn-secondary mt-3">Nazad na listu</a>
</div>

<?php include "../../admin-modules/footer.php"; ?>
