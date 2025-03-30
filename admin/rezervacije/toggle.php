<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: list.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT odobreno FROM rezervacije WHERE id = ?");
$stmt->execute([$id]);
$current = $stmt->fetchColumn();

if ($current === false) {
    header("Location: list.php");
    exit;
}

$new_value = $current ? 0 : 1;

$update = $pdo->prepare("UPDATE rezervacije SET odobreno = ? WHERE id = ?");
$update->execute([$new_value, $id]);

header("Location: list.php");
exit;
?>
