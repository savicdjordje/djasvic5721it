<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID nije prosleđen ili nije validan.</div>";
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM rezervacije WHERE id = ?");
$stmt->execute([$id]);
$rezervacija = $stmt->fetch();

if (!$rezervacija) {
    echo "<div class='alert alert-warning'>Rezervacija nije pronađena.</div>";
    exit;
}

$stmt = $pdo->prepare("DELETE FROM rezervacije WHERE id = ?");
$stmt->execute([$id]);

header("Location: list.php");
exit;
?>
