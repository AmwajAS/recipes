<?php
require_once("parts/header.php");
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';


if (isset($_POST['sign_up'])) {

    $username = get_post_param("username");
    $email =  get_post_param("email");
    $password =  get_post_param("password");
    $password_repeat =  get_post_param("password_repeat");

    $errors = array();

    if (emptyInputSignup($username, $email, $password, $password_repeat) !== false) {
        $errors[] = "Empty fields, please fill all";
    }
    if (invalidUid($username) !== false) {
        $errors[] = "Bad user name";
    }
    if (invalidEmail($email) !== false) {
        $errors[] = "Bad email";
    }
    if (pwdMatch($password, $password_repeat) !== false) {
        $errors[] = "Password mismatch";
    }
    if (get_user_by_email($conn, $email)) {
        $errors[] = "Email already exists!";
    }
    if (count($errors) == 0) {
        $vkey = md5(time() . $username);
        $insert = createUser($conn, $username, $email, $password, $vkey);
        if ($insert) {   //Valdiation Email 
            $restore = create_validate_email($vkey);
            echo "<p>Thank you for registering. We sent this email to valdiate your email.</p>:";
            echo "<a href='$restore'>Press here to valdiate email</a>";
            die();
        } else {
            echo "<p>Failed to sign up! try again later.";
        }
    }
}

?>

<div class="split-screen">
    <div class="left">
        <section class="copy">
            <h1 id="hf">SUAVE</h1>
            <p>You deserve it!</p>
        </section>
    </div>
    <div class="right">

        <form method="post" action="<?php print BASE_URL . "signUp.php" ?>">
            <?php if (count($errors) > 0) { ?>
                <div class="alert alert-danger">
                    <?php
                    foreach ($errors as $e) {
                        print $e;
                    }
                    ?>
                </div>
            <?php } ?>

            <section class="copy">
                <h2>Sign Up</h2>
                <div class="login-container">
                    <p>Already have an account? <a href="login.php">
                            <strong>Log In</strong></a></p>
                </div>
            </section>
            <div class="mb-3">
                <label for="username" class="form-label">Name</label>
                <input id="username" name="username" class="form-control" type="text">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" pattern="[^ @]*@[^ @]*" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" name="password" class="form-control" placeholder="Must be at least 6 charcters" type="password">
            </div>

            <div class="mb-3">
                <label for="password_repeat" class="form-label">Confirm Password</label>
                <input id="password_repeat" name="password_repeat" class="form-control" type="password" placeholder="Repeat password...">
                <i class="far fa-eye-slash"></i>
            </div>

            <button class="btn btn-primary" type="submit" name="sign_up">Sign Up</button>
            <section class="copy legal">
                <p><span class="small">By continuing, you are agree
                        to accept our <br><a href="">Privacy
                            Policy</a> &amp; <a href="">Terms of
                            Service</a>.</span></p>
            </section>
        </form>
    </div>
</div>
<?php require_once "parts/footer.php"; ?>