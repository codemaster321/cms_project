<?php
  if(isset($_GET['p_id']))
  {
  $p_id=$_GET['p_id'];
  }


  $query="SELECT * FROM posts WHERE post_id={$p_id}";
  $select_query=mysqli_query($connection,$query);
  confirm($select_query);
  while($row=mysqli_fetch_assoc($select_query))
  {
    $post_title=$row['post_title'];
    $post_author=$row['post_author'];
    $post_category_id=$row['post_category_id'];
    $post_status=$row['post_status'];
    $post_image=$row['post_image'];
    $post_tags=$row['post_tags'];
    $post_content=$row['post_content'];
    $post_date=$row['post_date'];
    $post_comment_count=$row['post_comment_count'];
  }

  if(isset($_POST['update_post']))
  {
    $post_title=$_POST['title'];
    $post_author=$_POST['author'];
    $post_category_id=$_POST['post_category'];
    $post_status=$_POST['post_status'];
    $post_image=$_FILES['image']['name'];
    $post_image_temp= $_FILES['image']['tmp_name'];
    $post_tags=$_POST['post_tags'];
    $post_content=$_POST['post_content'];

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if(empty($post_image))
    {
       $query="SELECT * FROM posts WHERE post_id={$p_id}";
       $image_query=mysqli_query($connection,$query);

       while($row=mysqli_fetch_array($image_query))
       {
         $post_image=$row['post_image'];
       }
    }





    $query="UPDATE posts SET ";
    $query.="post_title='{$post_title}',";
    $query.="post_category_id={$post_category_id},";
    $query.="post_date= now(),";
    $query.="post_author= '{$post_author}',";
    $query.="post_status= '{$post_status}',";
    $query.="post_tags= '{$post_tags}',";
    $query.="post_content= '{$post_content}',";
    $query.="post_image= '{$post_image}'";
    $query.=" WHERE post_id=$p_id";

    $update_query=mysqli_query($connection,$query);
    confirm($update_query);

    echo "<p class='bg-success'>Post Updated  <a href='../post.php?p_id=$p_id'>View Post</a> </p>";
  }


 ?>





<form class="" action="" method="post" enctype="multipart/form-data">

  <div class="form-group">

    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="title" value="<?php echo $post_title; ?>" >

  </div>

  <div class="form-group">

    <select class="" name="post_category">
      <?php

        $query="SELECT * from category";
        $cat_query=mysqli_query($connection,$query);
        confirm($cat_query);

        while($row=mysqli_fetch_assoc($cat_query))
        {
          $cat_id=$row['cat_id'];
          $cat_title=$row['cat_title'];

          echo "<option value='{$cat_id}'>{$cat_title}</option>";

        }



       ?>

    </select>

  </div>

  <div class="form-group">

    <label for="post_author"> Post Author </label>
    <input type="text" class="form-control" name="author" value="<?php echo $post_author; ?>">

  </div>


  <select class="" name="post_status">
    <option value=""><?php echo $post_status; ?></option>
    <?php

    if($post_status=="published")
    {
      echo "<option value='draft'>Draft</option>";
    }
    else
    {
      echo "<option value='published'>Publish</option>";
    }


     ?>

  </select>

  <!-- <div class="form-group">

    <label for="post_status"> Post Status </label>
    <input class="form-control" type="text" name="post_status" value="<?php echo $post_status; ?>" >

  </div> -->

  <div class="form-group">
    <label for="post_image"> Post Image </label>
    <input type="file" name="image" >

  </div>

  <div class="form-group">

    <label for="post_tags"> Post Tags </label>
    <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">

  </div>

  <div class="form-group">

    <label for="post_content"> Post Content </label>
    <textarea name="post_content" class="form-control" rows="10" cols="30"><?php echo $post_content; ?></textarea>

  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">

  </div>






</form>
