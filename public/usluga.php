<?php
require '../db.php';
require '../modules/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='w3-container w3-red w3-padding w3-margin'>Greška: Nije prosleđen validan ID usluge.</div>";
    require '../modules/footer.php';
    exit;
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT u.*, t.naziv AS tip_naziv, t.opis AS tip_opis
                        FROM usluga u
                        LEFT JOIN tip_usluge t ON u.tip_usluge_id = t.id
                        WHERE u.id = ? AND u.objavljeno = 1");
$stmt->execute([$id]);
$usluga = $stmt->fetch();

if (!$usluga) {
    echo "<div class='w3-container w3-yellow w3-padding w3-margin'>Usluga nije pronađena.</div>";
    require '../modules/footer.php';
    exit;
}
?>

<section class="w3-container w3-padding-64">
    <h2 class="w3-xxlarge"><?= $usluga['naziv'] ?></h2>

    <div class="w3-row-padding w3-margin-top">
        <div class="w3-col l6 m12">
            <img src="../<?= $usluga['slika'] ?>" style="width:100%; max-height:400px; object-fit:cover;" class="w3-image w3-round w3-margin-bottom" alt="<?= $usluga['naziv'] ?>">
        </div>
        <div class="w3-col l6 m12">
            <p><strong>Opis:</strong> <?= $usluga['opis'] ?></p>
            <p><strong>Cena:</strong> <?= $usluga['cena'] ?> RSD</p>
            <p><strong>Tip usluge:</strong> <?= $usluga['tip_naziv'] ?></p>
            <p><strong>Opis tipa usluge:</strong> <?= $usluga['tip_opis'] ?></p>
            <?php
            $nazad_link = 'katalog_usluga.php';
            if (isset($_GET['source']) && $_GET['source'] === 'index') {
                $nazad_link = '../index.php';
            }
            ?>
            <a href="<?= $nazad_link ?>" class="w3-button w3-black w3-margin-top">Nazad</a>
        </div>
    </div>
</section>

<?php require '../modules/footer.php'; ?>
