<?php
require_once "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>State List</title> <?php include('inc/css.php'); ?>
  </head>
  <body>
    <div class="container-scroller"> <?php include('inc/nev.php'); ?> <div class="container-fluid page-body-wrapper"> <?php include('inc/sidebar.php'); ?> <div class="main-panel">
          <div class="content-wrapper">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h3>State List</h3>
              <a href="add_state.php" class="btn btn-primary"> Add State  </a>
            </div>
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="myDataTable" class="table table-bordered table-striped">
                    <thead class="table-dark">
                      <tr>
                        <th>ID</th>
                        <th>State Name</th>
                        <th>Country Name</th>
                        <th>Status</th>
                        
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody> 
                        <?php

                            $sql="SELECT states.*,countries.country_name FROM `states` INNER JOIN `countries` WHERE states.country_id=countries.id ORDER BY id DESC";

                            $result=mysqli_query($conn,$sql);

                            while($row=mysqli_fetch_assoc($result))
                            {
                            ?> 
                        <tr>
                            <td> <?= $row['id']; ?> </td>
                            <td> <?= $row['state_name']; ?> </td>
                            <td> <?= $row['country_name']; ?> </td>
                            <td>
                                <span class="badge toggleStatus 
                                    <?=($row['status']=='1')?'bg-success':'bg-danger';?>" data-id="<?= $row['id']; ?>" style="cursor:pointer;"> <?=($row['status']=='1')?'Active':'Inactive';?> 
                                </span>
                            </td>
                            <td>
                            <a href="edit_state.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm"> Edit </a>
                            <a href="delete_state.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this state?')"> Delete </a>
                            </td>
                        </tr> 
                        <?php } ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> <?php include('inc/footer.php'); ?>
        </div>
      </div>
    </div> <?php include('inc/js.php'); ?> <script>
      $(function() {
        $(".toggleStatus").click(function() {
          var button = $(this);
          var id = button.data("id");
          $.ajax({
            url: "ajax/change_country_status.php",
            type: "POST",
            data: {
              id: id
            },
            success: function(response) {
              if (response == 1) {
                button.removeClass("bg-danger");
                button.addClass("bg-success");
                button.text("Active");
              } else {
                button.removeClass("bg-success");
                button.addClass("bg-danger");
                button.text("Inactive");
              }
            }
          });
        });
      });
    </script>
  </body>
</html>