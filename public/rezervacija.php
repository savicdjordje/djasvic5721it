<?php
require '../db.php';
require '../modules/header.php';

$usluge = $pdo->query("SELECT u.id, u.naziv, tu.naziv AS tip FROM usluga u JOIN tip_usluge tu ON u.tip_usluge_id = tu.id")->fetchAll();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usluga_id = $_POST['usluga_id'];
    $ime_prezime = trim($_POST['ime_prezime']);
    $email = trim($_POST['email']);
    $marka = trim($_POST['marka_auta']);
    $model = trim($_POST['model_auta']);
    $reg = trim($_POST['registracija_auta']);
    $opis = trim($_POST['dodatni_opis']);
    $datum_vreme = $_POST['datum_vreme'];

    if ($usluga_id === '' || $ime_prezime === '' || $email === '' || $datum_vreme === '') {
        $errors[] = "Polja sa zvezdicom (*) su obavezna.";
    }

    if (strpos($email, '@') == false) {
        $errors[] = "Email mora sadržati znak @.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO rezervacije (usluga_id, ime_prezime, email, marka_auta, model_auta, registracija_auta, dodatni_opis, datum_vreme)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$usluga_id, $ime_prezime, $email, $marka, $model, $reg, $opis, $datum_vreme])) {
            $success = true;
        } else {
            $errors[] = "Greška pri slanju rezervacije.";
        }
    }
}
?>

<div class="w3-container w3-padding-64" style="max-width:800px;margin:auto">
    <h2 class="w3-center">Forma za rezervaciju</h2>

    <?php if (!empty($errors)): ?>
        <div class="w3-panel w3-red w3-display-container">
            <span onclick="this.parentElement.style.display='none'"
                class="w3-button w3-large w3-display-topright">&times;</span>
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= $e ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif ($success): ?>
        <div class="w3-panel w3-green w3-display-container">
            <span onclick="this.parentElement.style.display='none'"
                class="w3-button w3-large w3-display-topright">&times;</span>
            Uspešno ste poslali rezervaciju!
        </div>
    <?php endif; ?>

    <form class="w3-container w3-card-4 w3-padding" method="POST">
        <p>
            <label>* Izaberite uslugu</label>
            <select name="usluga_id" class="w3-select" required>
                <option value="" disabled selected>Odaberite...</option>
                <?php foreach ($usluge as $row): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['tip'] ?> - <?= $row['naziv'] ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label>* Ime i prezime</label>
            <input class="w3-input w3-border" type="text" name="ime_prezime" required>
        </p>

        <p>
            <label>* Email adresa</label>
            <input class="w3-input w3-border" type="email" name="email" required>
        </p>

        <div class="w3-row-padding">
            <div class="w3-third">
                <p>
                    <label>Marka auta</label>
                    <input class="w3-input w3-border" type="text" name="marka_auta">
                </p>
            </div>
            <div class="w3-third">
                <p>
                    <label>Model auta</label>
                    <input class="w3-input w3-border" type="text" name="model_auta">
                </p>
            </div>
            <div class="w3-third">
                <p>
                    <label>Registracija auta</label>
                    <input class="w3-input w3-border" type="text" name="registracija_auta">
                </p>
            </div>
        </div>

        <p>
            <label>Dodatni opis</label>
            <textarea class="w3-input w3-border tinymce" name="dodatni_opis"></textarea>
        </p>

        <p>
            <label>* Datum i vreme</label>
            <input class="w3-input w3-border" type="datetime-local" name="datum_vreme" required>
        </p>

        <p class="w3-center">
            <button type="submit" class="w3-button w3-blue w3-hover-dark-grey">Pošalji rezervaciju</button>
        </p>
    </form>
</div>

<?php require '../modules/footer.php'; ?>
