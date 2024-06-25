<div class="container">
  <nav class="navbar navbar-expand-lg bg-light p-4">
    <div class="navbar-brand"><h1 class="fw-bolder"><a  class="text-danger" href="/">SUAVE</a></h1></div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <img src="images/menu_24px.png">
    </button>
    <div class="collapse navbar-collapse ml-lg text-right" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
        <?php if (is_logged_in()) { ?>
          <li class="nav-item">
            <a class="nav-link btn-light text-dark" href="recipes.php">Recipes</a>
          </li>
        <?php } ?>
        <?php if (is_logged_in()) { ?>
          <li class="nav-item">
            <a class="nav-link btn-light text-dark" href="logout.php">Log out</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </nav>
</div>