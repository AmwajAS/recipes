<?php
require_once("parts/header.php");
require_once('security.php');

$recipes = get_all_recipes($conn);
$action = isset($_GET["action"]) ? $_GET["action"] : "list";
$actions = array("list" => "List", "view" => "View", "edit" => "Edit", "add" => "New");
if ($actions[$action] === NULL) {
    die("Unknown action $action");
}
?>





<div class="container pt-4">
    <div class="header">
        <h1><?php print $actions[$action];?></h1>
    </div>
    <div class="wrapper mx-auto mt-4">
        <div class="row">
            <?php include_once "parts/recipes/$action.php"; ?>
        </div>
    </div>
</div>

<?php require_once "parts/footer.php"; ?>