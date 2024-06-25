<?php
require_once "parts/header.php";

$restore_url = NULL;
$error = NULL;
if (isset($_POST['forgot_password'])) {
    //check if his email is exist
    $user_email = get_post_param("user_email");
    if (!$user_email) {
        $error = "Email not specified";
    } else {
        $res = get_user_by_email($conn, $user_email);
        if ($res) {
            $restore_url = create_restore_passwordlink($user_email);
        } else {
            $error = "Failed to reset password, wrong email";
        }
    }
}
?>
<div class="container mt-4">
    <div class="wrapper">
        <div class="row">
            <div class="col-md-6">
                <div class="feature-box">
                    <div>
                        <h2>Reset your password</h2>
                    </div>
                    <?php if ($error) { ?>
                        <div class="alert alert-danger"><?php print $error; ?></div>
                    <?php } ?>
                    <?php if ($_POST && $restore_url) { ?>
                        <p>Mail for restore password</p>
                        <a href='<?php print $restore_url; ?>'>Press here to restore password</a>
                    <?php
                    } else { ?>
                        <form method="post" action="<?php print BASE_URL . "forgot.php" ?>">
                            <div class=" form-group">
                                <label for="user_email" class="form-label">Email</label>
                                <input type="email" id="user_email" name="user_email" type="user_email" class="form-control" placeholder="Enter email" />
                            </div>
                            <br>
                            <button type="submit" name="forgot_password" class="btn btn-primary btn-md">Reset</button>
                        </form>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "parts/footer.php"; ?>