<?php

require_once "parts/header.php";
if (isset($_GET['vkey'])) {
    //  Proccess Verification
    $vkey = $_GET['vkey'];

    $vkey = $conn->real_escape_string($vkey); // TODO: add more information
    $resultSet = $conn->query("SELECT verified,vkey FROM users WHERE verified = 0 AND vkey = '$vkey' LIMIT 1");

    if ($resultSet->num_rows == 1) {
        //Validate the email
        $update = $conn->query("UPDATE users SET verified = 1 WHERE vkey = '$vkey' LIMIT 1");
        if ($update) {
            echo "Your account has been verified. You may now login.";
        } else {
            echo $conn->error;
        }
    } else {
        die("Something went wrong");
    }
}

require_once "parts/footer.php";
