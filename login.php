<?php
require_once("parts/header.php");
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

$error = NULL;
if (isset($_POST["do_login"])) {

    $username = get_post_param("email");
    $password = get_post_param("password");
    $remember = get_post_param("remember");
    if (!$username || !$password) {
        $error = "Empty username or password";
    } else {
        $result = loginUser($conn, $username, $password, $remember);
        if ($result["error"]) {
            $error = $result["error"];
        } else {
            header("Location: recipes.php");
            die();
        }
    }
}

?>
<div class="container mt-4">
    <div class="wrapper">
        <?php if ($_SESSION["flash"]) : ?>
            <div class="alert alert-success">
                <?php print $_SESSION["flash"]; ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <div class="feature-box">
                    <div>
                        <h2>
                            Login to your account
                        </h2>
                        <p>Dont have an
                            account?&nbsp;<a href="signUp.php">Sign Up for Free!</a></p>
                    </div>
                    <?php if ($error) { ?>
                        <div class="alert alert-danger"><?php print $error; ?></div>
                    <?php } ?>

                    <form method="POST" action="login.php">

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" pattern="[^ @]*@[^ @]*" name="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control">
                        </div>

                        <div class="from-group">
                            <label>
                                <input id="check" type="checkbox" value="1" name="remember" <?php if (isset($_COOKIE["member_login"])) { ?> checked <?php } ?> /> Remember me
                            </label>
                        </div>
                        <br>
                        <div class="from-group">
                            <a href="forgot.php" id="a2">Forgot password?</a>
                        </div>
                        <br>
                        <button name="do_login" id="logBtn" type="submit" class="btn btn-primary btn-lg  md-12">login</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6 d-md-block">
                <img src="images/titans_2_food_blogger_4.jpg" class="feature-img">
            </div>
        </div>
    </div>
</div>

<?php
unset($_SESSION["flash"]);
require_once "parts/footer.php";
?>