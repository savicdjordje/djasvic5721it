<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";
$title = "Usluge";
include "../../admin-modules/header.php";

$query = "
    SELECT u.id, u.naziv, u.cena, u.objavljeno, u.istaknuto, tu.naziv AS tip_naziv
    FROM usluga u
    LEFT JOIN tip_usluge tu ON u.tip_usluge_id = tu.id
";

$stmt = $pdo->query($query);
$usluge = $stmt->fetchAll();
?>

<div class="container mt-5">
    <h2>Usluge</h2>
    <a href="create.php" class="btn btn-success mb-3">+ Nova usluga</a>

    <div class="mx-auto" style="max-width: 1000px;">
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="text-center">
                    <th>Naziv</th>
                    <th>Tip usluge</th>
                    <th>Cena (RSD)</th>
                    <th>Akcije</th>
                    <th>Objavljeno</th>
                    <th>Istaknuto</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($usluge) === 0): ?>
                    <tr>
                        <td colspan="6" class="text-center">Trenutno nema unetih usluga.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($usluge as $usluga): ?>
                    <tr>
                        <td>
                            <a href="detail.php?id=<?= $usluga['id'] ?>">
                                <?= $usluga['naziv'] ?>
                            </a>
                        </td>
                        <td><?= $usluga['tip_naziv'] ?></td>
                        <td><?= $usluga['cena'] ?></td>
                        <td class="text-center">
                            <a href="update.php?id=<?= $usluga['id'] ?>" class="btn btn-sm btn-primary me-2">Izmeni</a>
                            <a href="delete.php?id=<?= $usluga['id'] ?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Da li ste sigurni da želite da obrišete ovu uslugu?')">Obriši</a>
                        </td>
                        <td class="text-center">
                            <a href="toggle.php?polje=objavljeno&id=<?= $usluga['id'] ?>"
                            class="btn btn-sm <?= $usluga['objavljeno'] ? 'btn-success' : 'btn-outline-secondary' ?>">
                                <?= $usluga['objavljeno'] ? 'DA' : 'NE' ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="toggle.php?polje=istaknuto&id=<?= $usluga['id'] ?>"
                            class="btn btn-sm <?= $usluga['istaknuto'] ? 'btn-warning' : 'btn-outline-secondary' ?>">
                                <?= $usluga['istaknuto'] ? 'DA' : 'NE' ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "../../admin-modules/footer.php"; ?>
