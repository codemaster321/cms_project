<?php include "includes/header.php"; ?>



      <div id="page-wrapper">
        <?php include "includes/navigation.php"; ?>


          <div class="container-fluid">

              <!-- Page Heading -->
              <div class="row">
                  <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome bitch
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>

                    <?php

                      if(isset($_GET['source']))
                      {
                        $source=$_GET['source'];
                      }

                      else
                      { $source='';
                      }

                        switch($source)
                        {

                          case "add_post":
                            include "includes/add_post.php";
                            break;

                          case "edit_post":
                            include "includes/edit_post.php";
                            break;

                          case 100:
                              echo "100";
                              break;

                          case 200:
                            echo "200";
                            break;


                          default:
                                  echo "Default";
                                  include "includes/view_all_comments.php";
                                  break;


                      }

                     ?>


                  </div>
              </div>
              <!-- /.row -->

          </div>
          <!-- /.container-fluid -->

      </div>
      <!-- /#page-wrapper -->

      <?php include "includes/footer.php"; ?>
