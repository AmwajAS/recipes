<?php
require_once 'parts/header.php';
require_once 'security.php';
require_once 'includes/dbh.inc.php';

$id = isset($_GET['id']) ? $_GET['id'] : die("Missing Recipe Number");

if ($_POST) {
  $description = get_post_param("description");
  $method = get_post_param("method");
  $ingredients = get_post_param("ingredients");
  $image = get_post_param("image");
  update_recipe_by_id($conn, $id, $description, $method, $ingredients, $image);
}

$recipe = get_recipe_by_id($conn, $id);

?>
<div class="p-4">
  <form method="post" action="<?php print BASE_URL . "recipes.php?action=edit" ?>">
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input name="name" type="text" class="form-control" required value="<?php print $recipe["name"]; ?>">
    </div>
    <div class="mb-3">
      <label for="image" class="form-label">Image</label>
      <input name="image" type="text" class="form-control" required value="<?php print $recipe["image"]; ?>">
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="10" required><?php print $recipe["description"]; ?></textarea>
    </div>
    <div class="mb-3">
      <label for="ingredients" class="form-label">Ingredients</label>
      <textarea name="ingredients" class="form-control" rows="10" required><?php print $recipe["ingredients"]; ?></textarea>
    </div>
    <div class="mb-3">
      <label for="method" class="form-label">Method</label>
      <textarea name="method" class="form-control" rows="10" required><?php print $recipe["method"]; ?></textarea>
    </div>

    <button type="submit" class="btn btn-lg btn-primary">Submit</button>
  </form>
</div>