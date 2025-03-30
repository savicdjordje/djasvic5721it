<?php
require_once "../../db.php";
require_once "proveri-ulogovan.php";

$title = "Login administratora";
include "../../admin-modules/header.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Email i lozinka su obavezni!";
    } else {
        $sql = "SELECT * FROM administratori WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["email" => $email]);

        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            session_start();
            $_SESSION['user'] = $admin;
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Pogrešan email ili lozinka!";
        }
    }
}
?>

<div class="row">
    <div class="col-md-6">
        <h2>Prijava administratora</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group mb-3">
                <label for="email">Email adresa</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group mb-3">
                <label for="password">Lozinka</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button class="btn btn-primary">Prijavi se</button>
        </form>
    </div>
</div>

<?php include "../../admin-modules/footer.php"; ?>