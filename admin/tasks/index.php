<?php
require '../../connection/database.php';
require '../../middleware/authenticated.php';
?>


<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Manage Tasks - TMS</title>

    <?php include '../../layouts/header.php'; ?>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
		<?php include '../../layouts/sidebar.php'; ?>
        <!-- Layout container -->
        <div class="layout-page">
         <?php include '../../layouts/navbar.php'; ?>
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card">
                  <div class="card-header">
                    <a href="create.php" class="btn btn-sm btn-primary float-end">Add Task</a>
                  </div>  
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <td>SN</td>
                            <td>Title</td>
                            <td>Time</td>
                            <td>Image</td>
                            <td>Status</td>
                            <td>Actions</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $user_id = $_SESSION['user']['id'];
                            $select_query = "SELECT * FROM tasks WHERE user_id=$user_id";
                            $select_result = $conn->query($select_query);
                            $tasks = mysqli_fetch_all($select_result,MYSQLI_ASSOC);
                            $i=1;
                            foreach ($tasks as $task) {
                          ?>
                          <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?=$task['title']?></td>
                            <td><?=$task['time']?></td>
                            <td>
                              <a href="../../uploads/<?=$task['image']?>" target="_blank">
                                <img width="50" height="50" src="../../uploads/<?=$task['image']?>">
                              </a>
                            </td>
                            <td><span class="badge bg-primary"><?=$task['status'] ? 'Done' : 'Not done'?></span></td>
                            <td>
                              <?php 
                              if(!$task['status'])
                              {
                                ?>
                                  <a href="change-status.php?id=<?=$task['id']?>" class="btn btn-sm btn-success">Mark as done</a>
                                <?php
                              }
                              ?>
                              
                              <a href="edit.php?id=<?=$task['id']?>" class="btn btn-sm btn-primary">Edit</a>
                              <a href="delete.php?id=<?=$task['id']?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                </div>
                <div>
                  <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                  <a
                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    <?php include '../../layouts/footer.php'; ?>
  </body>
</html>