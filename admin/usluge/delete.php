<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";

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

if (!empty($usluga['slika']) && file_exists('../../' . $usluga['slika'])) {
    unlink('../../' . $usluga['slika']);
}

$stmt = $pdo->prepare("DELETE FROM usluga WHERE id = ?");
$stmt->execute([$id]);

header("Location: list.php");
exit;
?>
