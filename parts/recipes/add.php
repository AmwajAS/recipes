<?php
require_once 'parts/header.php';
require_once 'security.php';
require_once 'includes/dbh.inc.php';


if ($_POST) {
  $name = get_post_param("name");
  $description = get_post_param("description");
  $method = get_post_param("method");
  $ingredients = get_post_param("ingredients");
  $image = get_post_param("image");
  $user_id = get_current_userid();
  create_recipe($conn, $name, $description, $method, $ingredients, $image, $user_id);
  header("Location: recipes.php");
}

?>
<div class="p-4">
  <form method="post" action="<?php print BASE_URL . "recipes.php?action=add" ?>">
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input name="name" type="text" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="image" class="form-label">Image</label>
      <input name="image" type="text" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="10" required></textarea>
    </div>
    <div class="mb-3">
      <label for="ingredients" class="form-label">Ingredients</label>
      <textarea name="ingredients" class="form-control" rows="10" required></textarea>
    </div>
    <div class="mb-3">
      <label for="method" class="form-label">Method</label>
      <textarea name="method" class="form-control" rows="10" required></textarea>
    </div>

    <button type="submit" class="btn btn-lg btn-primary">Submit</button>
  </form>
</div>