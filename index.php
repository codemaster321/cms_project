<?php include "includes/header.php"; ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php";  ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

              <?php
              if(isset($_GET['page']))
              {
                $page=$_GET['page'];
              }
              else
              {
                $page="";
              }

              if($page==""|| $page==1)
              {
                $page_1=0;
              }
              else
              {
                $page_1=($page*5)-5;
              }

              $post_query="SELECT * FROM posts WHERE post_status='published'";
              $select_post_query=mysqli_query($connection,$post_query);
              $count= mysqli_num_rows($select_post_query);
              $perpage=ceil($count/9);



                $query="SELECT * FROM posts LIMIT $page_1,5 ";
                $select_all_posts_query=mysqli_query($connection,$query);
                $flag=true;

                while($row=mysqli_fetch_array($select_all_posts_query))
                {

                  $post_id= $row['post_id'];
                  $post_category_id= $row['post_category_id'];
                  $post_title= $row['post_title'];
                  $post_author= $row['post_author'];
                  $post_date= $row['post_date'];
                  $post_image= $row['post_image'];
                  $post_content= substr($row['post_content'],0,100);
                  $post_comment_count= $row['post_comment_count'];
                  $post_status= $row['post_status'];
                  $post_views_count= $row['post_views_count'];




                  if($post_status=='published')
                  {
                  ?>

                  <h1 class="page-header">
                      Page Heading
                      <small>Secondary Text</small>
                  </h1>

                  <!-- First Blog Post -->
                  <h2>
                      <a href="post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                  </h2>
                  <p class="lead">
                      by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                  </p>
                  <p><span class="glyphicon glyphicon-time"></span> Posted on<?php echo $post_date; ?></p>
                  <hr>

                <a href="post.php?p_id=<?php echo $post_id; ?>">  <img  class='img-responsive' src="images/<?php echo $post_image; ?>"> </a>
                  <hr>
                  <p> <?php echo $post_content; ?></p>



              <?php
                }
                else
                {
                  if($flag==false)
                    continue;

                  echo "<h1 class='text-center' > No Posts </h1>";
                  global $flag;
                  $flag=false;

                }

              }

               ?>



            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

        <ul class="pager">
          <?php

          for($i=1;$i<=$perpage;$i++)
          {
            if($i==$page)
            echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
            else
            echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
          }


           ?>
        </ul>

      <?php include "includes/footer.php"; ?>
