<?php
require '../db.php';
require '../modules/header.php';

$stmt = $pdo->query("SELECT u.*, t.naziv AS tip_usluge FROM usluga u
                        LEFT JOIN tip_usluge t ON u.tip_usluge_id = t.id
                        WHERE u.objavljeno = 1");
$usluge = $stmt->fetchAll();
?>

<section class="w3-container w3-center w3-padding-64">
    <h2 class="w3-xxlarge">Katalog usluga</h2>
    <p class="w3-large w3-opacity">
        U nastavku možete pogledati kompletnu ponudu naših profesionalnih usluga za lakiranje, poliranje i sređivanje automobila.
    </p>
</section>

<section class="w3-container w3-padding-64">
    <div class="w3-row-padding">
        <?php foreach ($usluge as $usluga): ?>
            <div class="w3-third w3-margin-bottom">
                <div class="w3-card-4">
                    <img src="../<?= $usluga['slika'] ?>" alt="<?= $usluga['naziv'] ?>" style="width:100%; height:220px; object-fit:cover;">
                    <div class="w3-container w3-padding">
                        <h5><?= $usluga['naziv'] ?></h5>
                        <p><?= $usluga['opis'] ?></p>
                        <p><strong>Tip usluge:</strong> <?= $usluga['tip_usluge'] ?></p>
                        <p><strong>Cena:</strong> <?= $usluga['cena'] ?> RSD</p>
                        <a href="usluga.php?id=<?= $usluga['id'] ?>&source=katalog" class="w3-button w3-black w3-margin-top">Opširnije</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require '../modules/footer.php'; ?>
