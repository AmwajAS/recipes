<?php
session_start();
require_once "includes/functions.inc.php";

if ($_POST) {
  $json = file_get_contents("php://input");
  $data = json_decode($json);
  $action = $data->action;

  if ($action === "none") {
    die("none action");
  }

  if ($action === "remove-user") {
    $res = unshare_recipe_with_user($conn, $data->recipe_id, $data->user_id);
    if ($res) {
      die(json_encode(array(
        "status" => "ok",
        "message" => "user removed",
      )));
    }
  }

  if ($action === "share-recipe") {
    $user = get_user_by_email($conn, $data->email);
    $owner_id = get_current_userid();
    $res = share_recipe_with_user($conn, $data->recipe_id, $owner_id,  $user["id"]);
    if ($res) {
      die(json_encode(array(
        "status" => "ok",
        "message" => "recipe shared",
        "user" => $user
      )));
    }
  }

  if ($action === "update-share") {
    $status = $data->name === 'reject' ? 'recjted' : 'accepted';
    $res = update_share($conn, $data->id, $status);
    if ($res) {
      die(json_encode(array(
        "status" => "ok",
        "message" => "updated",
      )));
    }
  }
}

if ($_GET) {
  $action = $_GET['action'];
  if ($action === 'auto-complete') {
    $term = $_GET['term'];
    $emails = get_users_by_search_term($conn, $term);
    die(json_encode($emails));
  }
  if ($action === 'get-shares') {
    $user_id = get_current_userid();
    $shares = get_user_shares($conn, $user_id);
    die(json_encode(array(
      "status" => "ok",
      "shares" => $shares
    )));
  }
}
