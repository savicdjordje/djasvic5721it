<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";
$title = "Tipovi usluga";
include "../../admin-modules/header.php";

$stmt = $pdo->query("SELECT * FROM tip_usluge");
$tipovi = $stmt->fetchAll();
?>

<div class="container mt-5">
    <h2>Tipovi usluga</h2>
    <a href="create.php" class="btn btn-success mb-3">+ Novi tip usluge</a>

    <div class="mx-auto" style="max-width: 800px;">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center">Naziv</th>
                    <th class="text-center">Akcije</th>
                </tr>
            </thead>
            <tbody>
            <?php if (count($tipovi) == 0): ?>
                <tr>
                    <td colspan="2" class="text-center">Nema unetih tipova usluga.</td>
                </tr>
            <?php endif; ?>
                <?php foreach ($tipovi as $tip): ?>
                    <tr>
                        <td class="text-center">
                            <a href="detail.php?id=<?= $tip['id'] ?>">
                                <?= $tip['naziv'] ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="update.php?id=<?= $tip['id'] ?>" class="btn btn-sm btn-primary me-2">Izmeni</a>
                            <a href="delete.php?id=<?= $tip['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni da želite da obrišete ovaj tip usluge?')">Obriši</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "../../admin-modules/footer.php"; ?>
