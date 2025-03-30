<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";

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

$stmt = $pdo->prepare("DELETE FROM tip_usluge WHERE id = ?");
$stmt->execute([$id]);

header("Location: list.php");
exit;
?>