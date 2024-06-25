<?php
require_once 'parts/header.php';
require_once 'security.php';
require_once 'includes/dbh.inc.php';

$id = isset($_GET['id']) ? $_GET['id'] : die("Missing Recipe Number");

$recipe = get_recipe_by_id($conn, $id);
$users = get_recipe_users($conn, $id);

?>

<div class="container">
  <div class="card p-5">
    <div class="card-title">
      <h1><?php print $recipe["name"]; ?>
        <?php if ($recipe["user_id"] === get_current_userid()) : ?>
          <a class="btn btn-primary btn-md" href="recipes.php?action=edit&id=<?php print $recipe['id'] ?>">
            Edit
          </a>
        <?php endif; ?>
      </h1>
    </div>
    <img src="<?php print $recipe["image"]; ?>" class="card-img-top w-25">
    <div class="card-text">
      <h2>Description</h2>
      <p><?php print nl2br($recipe["description"]); ?></p>
      <h2>Ingredients</h2>
      <?php print nl2br($recipe["ingredients"]); ?>
      <h2>Method</h2>
      <?php print nl2br($recipe["method"]); ?>
    </div>
  </div>
</div>
<div class="split-screen" class="d-flex flex-row" style="justify-content: center;">
  <div id="div4">

    <div style="text-align: center;">
      <!-- Button trigger modal -->
      <button id="shareButton" type="button" class="btn btn-primary d-flex justify-content-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
        SHARE RECIPE
      </button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">SHARE THE RECIPE WITH OTHERS </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php if ($recipe["user_id"] === get_current_userid()) { ?>
              <h6>
                Please enter the user email you want to share your recipe with.
              </h6>
              <div class="ui-widget">
                <div class="form-group">
                  <label for="email">Email: </label>
                  <input id="email" type="text" name="email" class="form-control">
                </div>
                <button type="button" class="btn btn-secondary" id="btn-share">Share</button>
              </div>

              <br>
              <?php } ?>
              <h6>Shared with:</h6>
              <table class="table">
                <thead>
                  <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <?php if ($recipe["user_id"] === get_current_userid()) { ?>
                      <th>Actions</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody id="users-tbody">
                  <?php foreach ($users as $user) { ?>
                    <tr id="user-row-<?php print $user['id'] ?>">
                      <td><?php print $user['email'] ?></td>
                      <td><?php print $user['name'] ?></td>
                      <?php if ($recipe["user_id"] === get_current_userid()) { ?>
                        <td>
                          <button type="button" class="btn btn-danger btn-remove-user" data-user-id="<?php print $user['id'] ?>">Remove</button>
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>

<script>
  var recipeId = <?php print $id; ?>;

  function toggleLineThrough(element) {
    if (element.checked) {
      document.getElementById("text").style.textDecoration = "line-through";
    } else {
      document.getElementById("text").style.textDecoration = "none";
    }

  }

  function removeUser(e) {
    var el = $(e.target);
    console.log(el, el.parent)
    var userId = el.data("user-id");
    $.ajax({
      url: "api.php",
      method: "POST",
      xhrFields: {
        withCredentials: true
      },
      dataType: "json",
      data: JSON.stringify({
        action: "remove-user",
        user_id: userId,
        recipe_id: recipeId
      })
    }).then(function(r) {
      if (r.status == "ok") {
        $("#user-row-" + userId).detach();
      }
    })
  }
  $(document).ready(function() {
    $(".btn-remove-user").bind("click", removeUser);

    $("#email").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "api.php",
          dataType: "json",
          method: "GET",
          data: {
            action: "auto-complete",
            term: request.term
          },
          success: function(data) {
            response(data);
          }
        });
      },
      minLength: 2,
      open: function() {
        $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
      },
      close: function() {
        $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
      }
    });

    $("#btn-share").bind("click", function(e) {
      var email = $("#email").val()
      $.ajax({
        url: "api.php",
        method: "POST",
        xhrFields: {
          withCredentials: true
        },
        dataType: "json",
        data: JSON.stringify({
          action: "share-recipe",
          email: email,
          recipe_id: recipeId
        })
      }).then(function(r) {
        if (r.status == "ok") {
          var userRow = $('<tr id="user-row-' + r.user.id + '"><td>' + r.user.email + '</td><td>' + r.user.name + '</td><td><button type="button" class="btn btn-danger btn-remove-user" data-user-id="' + r.user.id + '">Remove</button></td></tr>')
          $("#users-tbody").append(userRow);
          $(".btn-remove-user").unbind("click", removeUser);
          $(".btn-remove-user").bind("click", removeUser);
        }
      })


    });
  });
</script>