<?php include "includes/db.php"; ?>
<?php include "admin/functions.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Post - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="/cms/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/cms/css/blog-post.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>


    <?php


      if(isset($_POST['liked']))
      {
        //Fetching likes
        $post_id=$_POST['post_id'];
        $user_id=$_POST['user_id'];

        $query="SELECT * FROM posts WHERE post_id=$post_id";
        $post_query=mysqli_query($connection,$query);
        $post=mysqli_fetch_assoc($post_query);
        $likes=$post['likes'];

        if(mysqli_num_rows($post_query)>=1)
        {
          echo $post['post_id'];
        }

        //Updating likes
        mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");

        //Inserting likes in likes table
        mysqli_query($connection,"INSERT INTO likes(user_id,post_id) VALUES($user_id,$post_id)");
        exit();


      }

      if(isset($_POST['unliked']))
      {
        //Fetching likes
        $post_id=$_POST['post_id'];
        $user_id=$_POST['user_id'];

        $query="SELECT * FROM posts WHERE post_id=$post_id";
        $post_query=mysqli_query($connection,$query);
        $post=mysqli_fetch_assoc($post_query);
        $likes=$post['likes'];

        if(mysqli_num_rows($post_query)>=1)
        {
          echo $post['post_id'];
        }

        //Updating likes
        mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");

        //Inserting likes in likes table
        mysqli_query($connection,"UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");
        exit();


      }
     ?>



    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->

                <?php

                if(isset($_GET['p_id']))
                {
                  $post_id=$_GET['p_id'];
                  $view_query="UPDATE posts SET post_views_count=post_views_count+1 WHERE post_id=$post_id";
                  $select_view_query=mysqli_query($connection,$view_query);
                  confirm($select_view_query);

                  if(isset($_SESSION['user_role']) && $_SESSION['user_role']=='admin')
                    $query= "SELECT * FROM posts WHERE post_id={$post_id}";
                  else
                      $query= "SELECT * FROM posts WHERE post_id={$post_id} AND post_status='published'";


                  $select_query=mysqli_query($connection,$query);
                  confirm($select_query);
                  $post_count=mysqli_num_rows($select_query);

                  if($post_count<1)
                  {
                    echo "<h1> NO posts Unfortunately </h1>";
                  }
                  else
                  {

                  while($row=mysqli_fetch_assoc($select_query))
                  {
                    $post_title=$row['post_title'];
                    $post_author=$row['post_author'];
                    $post_date=$row['post_date'];
                    $post_image=$row['post_image'];
                    $post_content=$row['post_content'];
                  }





                 ?>



                <!-- Title -->
                <h1><?php echo $post_title; ?></h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#"><?php echo $post_author; ?></a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>

                <hr>

                <!-- Preview Image -->
                <img width="900" class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="">

                <hr>

                <!-- Post Content -->
              <?php echo $post_content; ?>

              <?php if(isLoggedin()): ?>
              <div class="row">
                  <p class="pull-right"> <a class="<?php echo userLikedThisPost($_GET['p_id'])?'unlike':'like' ?>" href="#"> <span class="glyphicon glyphicon-thumbs-up"></span> <?php echo userLikedThisPost($_GET['p_id'])?'Unlike':'Like' ?></a> </p>
              </div>
              <?php else: ?>
              <div class="row">
                <p class="pull-right"> <a href="login.php">Log in</a> here to like this post </p>
              </div>
            <?php endif; ?>



              <div class="row">
                  <p class="pull-right"> Likes:<?php echo getPostLikes($_GET['p_id']); ?> </p>
              </div>

              <div class="clearfix">

              </div>


                <hr>

                <!-- Blog Comments -->

                <?php
                  if(isset($_POST['create_comment']))
                  {
                     $the_post_id=$_GET['p_id'];

                     $comment_email=$_POST['comment_email'];
                     $comment_author=$_POST['comment_author'];
                     $comment_content=$_POST['comment_content'];

                     if(!empty($comment_email) && !empty($comment_author) && !empty($comment_content))
                     {
                       $query="INSERT INTO comments(comment_post_id,comment_author,comment_email,comment_content,comment_status,comment_date)";
                       $query.=" VALUES({$the_post_id},'{$comment_author}','{$comment_email}','{$comment_content}','unapproved',now())";
                       $create_comment_query=mysqli_query($connection,$query);
                       confirm($create_comment_query);

                       $query="UPDATE posts SET post_comment_count=post_comment_count+1 WHERE post_id={$the_post_id}";
                       $increase_comment_count=mysqli_query($connection,$query);
                       confirm($increase_comment_count);
                     }

                     else
                     {
                       echo"
                       <script>
                         alert('Field empty bitch');
                       </script>";
                     }

                  }


                 ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form auto action="" method="post" role="form">
                      <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" name="comment_author" value="">

                      </div>

                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="comment_email" value="">

                      </div>

                        <div class="form-group">
                          <label for="comment">Your Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php
                $query= "SELECT * FROM comments WHERE comment_post_id=$post_id";
                $query.=" AND comment_status='approved' ";
                $query.=" ORDER BY comment_id DESC";
                $fetch_comments_query=mysqli_query($connection,$query);
                while($row=mysqli_fetch_assoc($fetch_comments_query))
                {
                  $comment_author=$row['comment_author'];
                  $comment_date=$row['comment_date'];
                  $comment_content=$row['comment_content'];

                 ?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>
              <?php  } } }?>

                <!-- Comment -->
                <!-- <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        Nested Comment
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
                        End Nested Comment
                    </div>
                </div> -->

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>

        </div>
        <!-- /.row -->

        <hr>



    </div>
    <!-- /.container -->

    <!-- jQuery -->

    <?php include "includes/footer.php"; ?>




    <script>

    $(document).ready(function()
  {
    var post_id=<?php echo $_GET['p_id'];  ?>;
    //Fetching user id
  console.log(post_id);



    var user_id= <?php echo loggedInUserID(); ?>;
    $('.like').click(function()
  {
      $.ajax({
        url:"/cms/post.php?p_id=<?php echo $_GET['p_id'];?>",
        type:'post',
        data:{
          'liked':1,
          'post_id':post_id,
          'user_id':user_id,
        }
      });
  });

  $('.unlike').click(function()
{
    $.ajax({
      url:"/cms/post.php?p_id=<?php echo $_GET['p_id'];?>",
      type:'post',
      data:{
        'unliked':1,
        'post_id':post_id,
        'user_id':user_id,
      }
    });
});









  });

    </script>
