<?php
require_once "parts/header.php";
require_once "includes/dbh.inc.php";

$user_email = $_GET["secret"];
$user_email = mysqli_real_escape_string($conn, $user_email);
$sql = "SELECT * FROM `users` WHERE email = '$user_email'";
$results = $conn->query($sql);
if ($results->num_rows < 0) {
    die("User code inncorrect");
}
if (isset($_POST['restore_password'])) {
    $user_email = $_POST["secret"];
    $user_password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];

    if (empty($user_password) || empty($password_repeat)) {
        echo "One or more of the fields are empty";
    } else if ($user_password != $password_repeat) {
        echo "The passwords don't match";
    } else {
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "There was an error!";
            exit();
        } else {
            $newPwdHash = password_hash($user_password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $user_email);
            mysqli_stmt_execute($stmt);
            $_SESSION["flash"] =  "The password changed Successfully! Go to log in.";
            header("Location: login.php");
        }
    }
}





?>
<div class="container mt-4">
    <div class="wrapper p-4">
        <form method="post" action="<?php print BASE_URL . "restore.php" ?>">
            <input type="hidden" name="secret" value="<?php print $user_email; ?>" />
            <label for="password"> Your new password: </label>
            <input id="password" name="password" type="password" class="form-control" />
            <br>
            <label for="password_repeat"> Repeat your new password: </label>
            <input id="password_repeat" name="password_repeat" type="password" class="form-control" />
            <br>
            <input type="submit" name="restore_password" value="Reset password" class="btn btn-success" />
        </form>
    </div>
</div>

<?php require_once "parts/footer.php"; ?>