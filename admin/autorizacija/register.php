<?php
require_once '../../db.php';
require_once "proveri-ulogovan.php";

$title = "Registracija administratora";
include "../../admin-modules/header.php";

$greska = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime_prezime = $_POST['ime_prezime'] ?? '';
    $email = $_POST['email'] ?? '';
    $raw_password = $_POST['password'] ?? '';

    if (empty($ime_prezime) || empty($email) || empty($raw_password)) {
        $greska = "Sva polja su obavezna.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $greska = "Unesite ispravnu email adresu.";
    } else {
        $password = password_hash($raw_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO administratori (ime_prezime, email, password) VALUES (:ime, :email, :pass)");

        try {
            $stmt->execute([
                'ime' => $ime_prezime,
                'email' => $email,
                'pass' => $password
            ]);

            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $greska = "Greška: Email već postoji ili je došlo do problema pri registraciji.";
        }
    }
}
?>

<div class="row">
    <div class="col-md-6">
        <h2>Registracija administratora</h2>

        <?php if (!empty($greska)): ?>
            <div class="alert alert-danger"><?= $greska ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group mb-3">
                <label for="ime_prezime">Ime i prezime</label>
                <input type="text" name="ime_prezime" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="email">Email adresa</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="password">Lozinka</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Registruj se</button>
        </form>
    </div>
</div>

<?php include "../../admin-modules/footer.php"; ?>
