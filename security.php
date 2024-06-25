<?php
require_once 'includes/functions.inc.php';
if (!is_logged_in()) {
  header('Location: login.php');
  die();
}
