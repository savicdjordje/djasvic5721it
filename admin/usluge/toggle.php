<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";

$dozvoljena_polja = ['objavljeno', 'istaknuto'];

if (!isset($_GET['id'], $_GET['polje']) || !in_array($_GET['polje'], $dozvoljena_polja)) {
    header("Location: list.php");
    exit;
}

$id = (int) $_GET['id'];
$polje = $_GET['polje'];

$stmt = $pdo->prepare("SELECT $polje FROM usluga WHERE id = ?");
$stmt->execute([$id]);
$trenutna_vrednost = $stmt->fetchColumn();

$nova_vrednost = $trenutna_vrednost ? 0 : 1;

$update = $pdo->prepare("UPDATE usluga SET $polje = ? WHERE id = ?");
$update->execute([$nova_vrednost, $id]);

header("Location: list.php");
exit;
