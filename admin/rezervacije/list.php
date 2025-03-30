<?php
require_once "../../db.php";
require_once "../autorizacija/proveri-pristup.php";
$title = "Rezervacije";
include "../../admin-modules/header.php";

$query = "
    SELECT r.*, u.naziv AS usluga_naziv
    FROM rezervacije r
    LEFT JOIN usluga u ON r.usluga_id = u.id
    ORDER BY r.datum_vreme DESC
";

$stmt = $pdo->query($query);
$rezervacije = $stmt->fetchAll();
?>

<div class="container mt-5">
    <h2>Pregled rezervacija</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr class="text-center">
                    <th>Ime i prezime</th>
                    <th>Usluga</th>
                    <th>Auto</th>
                    <th>Datum</th>
                    <th>Odobreno</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rezervacije as $r): ?>
                    <tr>
                        <td><?= $r['ime_prezime'] ?></td>
                        <td><?= $r['usluga_naziv'] ?></td>
                        <td><?= "{$r['marka_auta']} - {$r['model_auta']} - ({$r['registracija_auta']})" ?></td>
                        <td><?= $r['datum_vreme'] ?></td>
                        <td class="text-center">
                            <a href="toggle.php?id=<?= $r['id'] ?>" class="btn btn-sm <?= $r['odobreno'] ? 'btn-success' : 'btn-outline-secondary' ?>">
                                <?= $r['odobreno'] ? 'DA' : 'NE' ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="detail.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-primary me-2">Detalji</a>
                            <a href="delete.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Obrisati rezervaciju?')">Obriši</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "../../admin-modules/footer.php"; ?>
