<div class="col-md-6">
  <a class="m-4 btn btn-success" href="recipes.php?action=add">Add new</a>
  <div class="feature-box">
    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for recipe names.." title="Type in a name" />
    <table id="myTable" class="table table-sortable">
      <p> *You can sort the table by pressing the column header.</p>
      <thead class="table-hover table-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Recipe Name</th>
          <th scope="col">Publish Date</th>
          <th scope="col">Publisher</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recipes as $recipe) { ?>
          <tr class='clickable-row'>
            <th scope="row"><?php print $recipe['id'] ?> </th>
            <td>
              <a href="<?php print BASE_URL; ?>recipes.php?action=view&id=<?php print $recipe['id'] ?>">
                <?php print $recipe['name'] ?>
              </a>
            </td>
            <td><?php print $recipe['published_at'] ?></td>
            <td><?php print $recipe['username'] ?></td>
          </tr>
        <?php } ?>

        </tr>
      </tbody>
    </table>

    <script src="./src/tablesort.js"></script>
    <link rel="stylesheet" href="./src/tablesort.css" />
    <p> </p>
  </div>
</div>
<div class="col-md-6">
  <img src="images/table.jpg" class="feature-img">
</div>

<script type="text/javaScript">

  function myFunction() {
                            var input, filter, table, tr, td, i, txtValue;
                            input = document.getElementById("myInput");
                            filter = input.value.toUpperCase();
                            table = document.getElementById("myTable");
                            tr = table.getElementsByTagName("tr");
                            for (i = 0; i < tr.length; i++) {
                              td = tr[i].getElementsByTagName("td")[0];
                              if (td) {
                                txtValue = td.textContent || td.innerText;
                                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                  tr[i].style.display = "";
                                } else {
                                  tr[i].style.display = "none";
                                }
                              }       
                            }
                          }
                          </script>

<div class="modal" tabindex="-1" role="dialog" id="shares-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Shares</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-shares-modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>New shares</p>
        <div id="shares"></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $.ajax({
      url: 'api.php',
      data: {
        action: 'get-shares'
      },
      xhrFields: {
        withCredentials: true
      },
      dataType: "json",
    }).then(function(response) {
      if (response.shares.length > 0) {
        $("#shares-modal").modal('show');
        var table = $("<table class='table'><tr><th>Name</th><th>From</th><th>Action</th></tr>");
        response.shares.forEach(function(r) {
          var tr = $("<tr class='share-id-" + r.id + "'><td>" + r.recipe_name + "</td><td>" +
            r.owner_name + "</td>" +
            "<td><button class='btn-action btn btn-sm btn-success m-1' data-name='accept' data-id='" + r.id + "'>Accept</button>" +
            "<button class='btn-action btn btn-sm btn-danger m-1' data-name='reject' data-id='" + r.id + "'> Reject </button></td > " +
            "</tr>");
          table.append(tr);
        });

        $("#shares").html(table);
        $(".btn-action").bind("click", function(e) {
          var el = $(e.target);
          var name = el.data("name");
          var id = el.data("id");
          $.ajax({
            url: 'api.php',
            method: 'POST',
            data: JSON.stringify({
              action: 'update-share',
              id: id,
              name: name
            }),
            xhrFields: {
              withCredentials: true
            },
            dataType: "json",
          }).then(function(r) {
            if (r.status === "ok") {
              $(".share-id-" + id).detach();
            }
          });
        });
      }
    });
    $("#close-shares-modal").bind("click", function(e) {
      $("#shares-modal").modal('hide');

    })

  })
</script>