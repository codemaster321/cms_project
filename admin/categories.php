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





                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>

                    <div class="col-xs-6">

                      <?php
                      //insert new categories
                        insert_categories();
                       ?>


                      <form  method="post">

                        <div class="form-group">
                          <label for="cat_title"></label>
                          <input type="text" class="form-control" name="cat_title" value="">
                        </div>

                        <div class="form-group">
                          <input type="submit" class="btn btn-primary" name="submit" value="Add Category">

                        </div>

                      </form>

                      <form  method="post">

                        <div class="form-group">
                          <label for="cat_title"></label>

                        </div>

                        <div class="form-group">

                          <?php
                          if(isset($_GET['edit']))
                          {
                            $cat_id=$_GET['edit'];
                            $query= "SELECT * FROM category WHERE cat_id= $cat_id ";
                            $categories_query=mysqli_query($connection,$query);

                            while($row=mysqli_fetch_assoc($categories_query))
                            {
                              $cat_id=$row['cat_id'];
                              $cat_title=$row['cat_title'];

                            ?>

                            <input type="text" class="form-control" name="cat_title" value="<?php if(isset($cat_title)) {echo $cat_title; } ?>">


                          <?php }  }?>
                        </div>




                        <div class="form-group">
                          <?php
                          if(isset($_POST['update_category']))
                          {
                            $the_cat_title=$_POST['cat_title'];

                            $stmt= mysqli_prepare($connection,"UPDATE category SET cat_title=? WHERE cat_id=?");
                            mysqli_stmt_bind_param($stmt,"si",$the_cat_title,$cat_id);
                            mysqli_stmt_execute($stmt);

                            mysqli_stmt_close($stmt);

                            header("Location: categories.php");
                          }



                           ?>

                          <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">

                        </div>

                      </form>

                    </div>

                    <div class="col-xs-6">

                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Category Title</th>

                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <?php
                            //Find all the categories query
                            findAllCategories();

                             ?>




                             <?php
                             //delete categories
                             deleteCategories()

                              ?>

                            <!-- <td>1</td> -->
                            <!-- <td>Baseball</td> -->
                          </tr>
                        </tbody>
                      </table>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "includes/footer.php"; ?>
