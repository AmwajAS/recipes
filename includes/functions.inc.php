<?php
require_once "dbh.inc.php";

function emptyInputSignup($username, $email, $pwd, $pwdRepeat)
{
    return empty($username) || empty($email) || empty($pwd) || empty($pwdRepeat);
}

function invalidUid($username)
{
    $result = false;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}


function invalidEmail($email)
{
    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}


function pwdMatch($pwd, $pwdRepeat)
{
    return $pwd !== $pwdRepeat;
}

function get_full_user_by_email($conn, $email)
{
    $sql = "
        SELECT * FROM users WHERE email = ?;
    ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("Statment failed");
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $cur = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($cur)) {
        return $row;
    } else {
        return false;
    }
    mysqli_stmt_close($stmt);
}

function createUser($conn, $username, $email, $pwd, $vkey)
{
    $sql = "
        INSERT INTO users (email, name, password, vkey) 
        VALUES (?, ?, ?, ?);
    ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    } else {
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $email, $username, $hashedPwd, $vkey);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return true;
    }
}


function emptyInputlogin($username, $pwd)
{
    $result = false;
    if (empty($username) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

//Make the user login if he has an account
function loginUser($conn, $email, $pwd, $remember)
{
    $result = array("error" => NULL);
    $user = get_full_user_by_email($conn, $email);
    if ($user === false) {
        $result["error"] = "User does not exist";
        return $result;
    }

    //Get the password from the data base
    $pwdHashed = $user["password"];
    $check = password_verify($pwd, $pwdHashed);
    //Checking if the password is correct
    if ($check === false) {
        $result["error"] = "Wrong password";
        return $result;
    } else if ($check === true) {
        if ($remember == 1) {
            setcookie("email", $email, time() + (10 * 365 * 24 * 60 * 60));
        }
        $_SESSION["logged_in"] = 1;
        $_SESSION["logged_userid"] = $user['id'];
        return $result;
    }
}
function create_restore_passwordlink($usersEmail)
{
    return BASE_URL . "restore.php?secret=$usersEmail";
}

function create_validate_email($vkey)
{
    return BASE_URL . "validate.php?vkey=$vkey";
}
function is_logged_in()
{
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == 1) {
        return true;
    }
    return false;
}
function get_all_recipes($conn)
{

    $sql = "
        SELECT r.*, u.name as username FROM `recipes` r 
        JOIN `users` u ON r.user_id = u.id  ;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("Failed to prepare statement");
    }
    mysqli_stmt_execute($stmt);
    $cur = mysqli_stmt_get_result($stmt);
    $result = array();
    while ($row = mysqli_fetch_assoc($cur)) {
        $result[] = $row;
    }
    return $result;
}


function get_user_by_email($conn, $email)
{

    $sql = "SELECT id, email, name FROM `users` WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $cur = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($cur);
    return $row;
}
function get_current_userid()
{
    return intval($_SESSION["logged_userid"]);
}
function get_recipe_by_id($conn, $id)
{

    $sql = "
        SELECT r.*, u.name as username FROM `recipes` r 
        JOIN `users` u ON r.user_id = u.id 
        WHERE r.id = ? ;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $cur = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($cur);
    return $row;
}

function update_recipe_by_id($conn, $id, $description, $method, $ingredients, $image)
{

    $sql = "
        UPDATE `recipes` 
        SET 
            `description` = ?, 
            `method` = ? , 
            `ingredients` = ?,
            `image` = ? 
        WHERE `recipes`.`id` = ?
    ";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $description, $method, $ingredients, $image, $id);
    mysqli_stmt_execute($stmt);
}


function get_post_param($name, $default = NULL)
{
    if (isset($_POST) && $_POST[$name]) {
        return $_POST[$name];
    }
    return $default;
}


function get_recipe_users($conn, $recipe_id)
{
    $sql = "
        SELECT u.id, u.name, u.email FROM `users_recipes` ur
        JOIN `users` u ON u.id = ur.user_id
        WHERE ur.recipe_id = ? AND ur.status = 'accepted'   
        ";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "i", $recipe_id);
    if (!mysqli_stmt_execute($stmt)) {
        die("Failed to prepare statement in `get_recipe_users`" . mysqli_error($conn));
    }
    $cur = mysqli_stmt_get_result($stmt);
    $results = array();
    while ($row = mysqli_fetch_assoc($cur)) {
        $results[] = $row;
    }
    return $results;
}

function unshare_recipe_with_user($conn, $recipe_id, $user_id)
{
    $sql = "DELETE FROM `users_recipes` WHERE recipe_id = ? AND user_id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("Failed to prepare statement in `get_recipe_users`" . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "ii", $recipe_id, $user_id);
    if (!mysqli_stmt_execute($stmt)) {
        die("Failed to prepare statement in `get_recipe_users`" . mysqli_error($conn));
    }
    return TRUE;
}



function get_users_by_search_term($conn, $term)
{
    $sql = "SELECT email FROM `users` WHERE email LIKE ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    $term = "%$term%";
    mysqli_stmt_bind_param($stmt, "s", $term);
    if (!mysqli_stmt_execute($stmt)) {
        die("Failed to prepare statement in `get_users_by_search_term`" . mysqli_error($conn));
    }
    $cur = mysqli_stmt_get_result($stmt);
    $results = array();
    while ($row = mysqli_fetch_assoc($cur)) {
        $results[] = $row["email"];
    }
    return $results;
}

function share_recipe_with_user($conn, $recipe_id, $owner_id, $user_id)
{
    $sql = "
        INSERT INTO `users_recipes`(recipe_id, owner_id, user_id, created_at, status)
        VALUES(?, ?, ?, NOW(), 'pending')
    ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("Failed to prepare statement in `share_recipe_with_user`" . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "iii", $recipe_id, $owner_id, $user_id);
    if (!mysqli_stmt_execute($stmt)) {
        die("Failed to prepare statement in `share_recipe_with_user`" . mysqli_error($conn));
    }
    return TRUE;
}

function get_user_shares($conn, $user_id)
{
    $sql = "SELECT ur.id, r.name as recipe_name, u.name as owner_name
     FROM `users_recipes` ur 
     JOIN `recipes` r ON r.id = ur.recipe_id
     JOIN `users` u ON u.id = ur.owner_id
     WHERE ur.user_id = ? and status = 'pending'";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    if (!mysqli_stmt_execute($stmt)) {
        die("Failed to prepare statement in `get_user_shares`" . mysqli_error($conn));
    }
    $cur = mysqli_stmt_get_result($stmt);
    $results = array();
    while ($row = mysqli_fetch_assoc($cur)) {
        $results[] = $row;
    }
    return $results;
}


function create_recipe($conn, $name, $description, $method, $ingredients, $image, $user_id)
{

    $sql = "
        INSERT INTO `recipes` (`name`, `description` , `method`, `ingredients`, `image`, `user_id`, `published_at`)
        VALUES(?, ?, ?, ?, ?, ?, NOW())
    ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("Failed to prepare statement in `create_recipe`" . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "sssssi", $name, $description, $method, $ingredients, $image, $user_id);
    if (!mysqli_stmt_execute($stmt)) {
        die("Failed to prepare statement in `create_recipe`" . mysqli_error($conn));
    }
}


function update_share($conn, $id, $status)
{
    $sql = "UPDATE `users_recipes` SET status = ? WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $id);
    if (!mysqli_stmt_execute($stmt)) {
        die("Failed to prepare statement in `update_share`" . mysqli_error($conn));
    }
    return TRUE;
}
