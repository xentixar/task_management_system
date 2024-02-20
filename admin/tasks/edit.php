<?php
require '../../connection/database.php';
require '../../middleware/authenticated.php';

if(isset($_GET['id']))
{
  $id = $_GET['id'];
  if($id && is_numeric($id))
  {
    $user_id = $_SESSION['user']['id'];
    $select_query = "SELECT * FROM tasks WHERE id=$id AND user_id=$user_id";
    $select_result = $conn->query($select_query);
    $task = mysqli_fetch_assoc($select_result);

    if(!$task)
    {
      ?>
        <script type="text/javascript">
            window.location.href="index.php";
          </script>
      <?php
    }
  }else{
    ?>
      <script type="text/javascript">
          window.location.href="index.php";
        </script>
    <?php
  }
}else{
  ?>
  <script type="text/javascript">
      window.location.href="index.php";
    </script>
  <?php
}

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

    <title>Edit Task - TMS</title>

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
                    <a href="index.php" class="btn btn-sm btn-primary float-end">Manage Tasks</a>
                  </div>  
                  <div class="card-body">
                    <?php 
                      if(isset($_POST['submit']))
                      {
                        $title = $_POST['title'] ?? '';
                        $time = $_POST['time'] ?? '';
                        $image = $_FILES['image'] ?? '';

                        if($title!="" && $time!="")
                        {

                          $image_name = $image['name'] ?? '';
                          $image_size = $image['size'] ?? 0;
                            if($image_name!="")
                            {
                                $exploded_data = explode('.', $image_name);
                                $extension = strtolower(end($exploded_data));

                                if($extension==='jpg' || $extension==='png' || $extension==='jpeg')
                                {
                                  if($image_size>0 && $image_size<2097152)
                                  {
                                    $name = strtolower(str_replace(" ", "", substr($title, 0,15)) . "-" . time() . "." . $extension);
                                    if(move_uploaded_file($image['tmp_name'], '../../uploads/'. $name)){
                                      unlink('../../uploads/'. $task['image']);
                                      $user_id = $_SESSION['user']['id'];
                                      $update_query = "UPDATE tasks SET title='$title',time='$time',image='$name' WHERE id=$id AND user_id=$user_id";
                                      $update_result = $conn->query($update_query);

                                      if($update_result)
                                      {
                                        ?>
                                        <script type="text/javascript">
                                          window.location.href="index.php";
                                        </script>
                                        <?php
                                      }else{
                                        ?>
                                          <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Data insertion failed. Please try again.</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                          </div>
                                        <?php
                                      }
                                    }else{
                                      ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                          <strong>Image upload failed. Please try again.</strong>
                                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                      <?php
                                    }
                                  }else{
                                    ?>
                                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Image should be less than 2 MB.</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                      </div>
                                    <?php
                                  }
                                }else{
                                  ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                      <strong>Only jpg,jpeg and png format supported.</strong>
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                  <?php
                                }
                            }else{
                              $user_id = $_SESSION['user']['id'];
                              $update_query = "UPDATE tasks SET title='$title',time='$time' WHERE id=$id AND user_id=$user_id";
                             $update_result = $conn->query($update_query);

                            if($update_result)
                            {
                              ?>
                              <script type="text/javascript">
                                window.location.href="index.php";
                              </script>
                              <?php
                            }else{
                              ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  <strong>Data insertion failed. Please try again.</strong>
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                              <?php
                            }
                          }
                        }else{
                          ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <strong>All fields are required.</strong>
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                          <?php
                        }
                      }
                    ?>
                    <form action="#" method="POST" enctype="multipart/form-data">
                      <div class="form-group mb-3">
                        <label class="form-label" for="title">Title <b>*</b></label>
                        <input type="text" class="form-control" name="title" id="title" value="<?=$task['title']?>" required>
                      </div> 
                      <div class="form-group mb-3">
                        <label class="form-label" for="time">Time <b>*</b></label>
                        <input type="time" class="form-control" name="time" id="time" value="<?=$task['time']?>" required>
                      </div> 
                      <div class="form-group mb-3">
                        <label class="form-label" for="image">Image <b>*</b></label>
                        <input type="file" class="form-control" name="image" id="image">
                        <a href="../../uploads/<?=$task['image']?>" target="_blank">
                            <img width="50" height="50" src="../../uploads/<?=$task['image']?>">
                        </a>
                      </div> 
                      <button class="btn btn-primary" type="submit" name="submit">Update Task</button>
                    </form>
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