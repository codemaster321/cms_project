<?php include "includes/header.php"; ?>
<?php include "admin/functions.php"; ?>
    <!-- Navigation -->
    <?php include "includes/navigation.php";  ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

              <?php

               ?>



              <?php
            
              if(isset($_GET['cat_id']))
              {
                $post_category_id=$_GET['cat_id'];

              if(is_admin($_SESSION['username']))
              {
                // echo $post_category_id;
                // echo "HELLO";
                $stmt1= mysqli_prepare($connection,"SELECT post_id,post_author,post_title,post_date,post_image,post_content FROM posts WHERE post_category_id=?");
              }
              else{
              $stmt2= mysqli_prepare($connection,"SELECT post_id,post_author,post_title,post_date,post_image,post_content FROM posts WHERE post_category_id=? AND post_status=?");
              $published='published';
            }


              if(isset($stmt1))
              {
                // echo "HELLO";
                mysqli_stmt_bind_param($stmt1,"i",$post_category_id);

                mysqli_stmt_execute($stmt1);

                mysqli_stmt_bind_result($stmt1,$post_id,$post_author,$post_title,$post_date,$post_image,$post_content);
                $stmt=$stmt1;
              }
              else
              {
                mysqli_stmt_bind_param($stmt2,"is",$post_category_id,$published);

                mysqli_stmt_execute($stmt2);

                mysqli_stmt_bind_result($stmt2,$post_id,$post_author,$post_title,$post_date,$post_image,$post_content);
                $stmt=$stmt2;
              }

             //
             //    $category_post_count=mysqli_stmt_num_rows($stmt);
             // echo $category_post_count;
             //
             //
             //
             //    if($category_post_count<1)
             //    {
             //      echo "<h1> NO posts Unfortunately lmao</h1>";
             //      exit;
             //    }
                // else
                // {

                while(mysqli_stmt_fetch($stmt)):



                  ?>



                  <h1 class="page-header">
                      Page Heading
                      <small>Secondary Text</small>
                  </h1>

                  <!-- First Blog Post -->
                  <h2>
                      <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                  </h2>
                  <p class="lead">
                      by <a href="index.php"><?php echo $post_author; ?></a>
                  </p>
                  <p><span class="glyphicon glyphicon-time"></span> Posted on<?php echo $post_date; ?></p>
                  <hr>
                  <img  class='img-responsive' src="images/<?php echo $post_image; ?>">
                  <hr>
                  <p> <?php echo $post_content; ?></p>
                  <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                  <hr>

              <?php
             endwhile;
           mysqli_stmt_close($stmt);


         } else{

           header("Location: /cms/index");
         }
               ?>



            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php //include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

      <?php include "includes/footer.php"; ?>
