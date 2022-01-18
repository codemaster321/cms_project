<?php
include("delete_modal.php");

if(isset($_POST['checkBoxArray']))
{


  foreach($_POST['checkBoxArray'] as $checkBoxV)
  {
    $bulk_options=$_POST['bulk_options'];

    switch($bulk_options)
    {
      case "published":
        $query= "UPDATE posts SET post_status='{$bulk_options}' WHERE post_id={$checkBoxV}";
        $published_query=mysqli_query($connection,$query);
        confirm($published_query);
        break;

      case "draft":
        $query= "UPDATE posts SET post_status='{$bulk_options}' WHERE post_id={$checkBoxV}";
        $draft_query=mysqli_query($connection,$query);
        confirm($draft_query);
        break;

      case "delete":
        $query= "DELETE FROM posts WHERE post_id={$checkBoxV}";
        $delete_query=mysqli_query($connection,$query);
        confirm($delete_query);
        break;

        case 'clone':
        $query="SELECT * FROM posts WHERE post_id={$checkBoxV}";
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
            $post_views_count=$row['post_views_count'];
          }

          $query= "INSERT INTO posts(post_category_id, post_title, post_author,post_date,post_image,post_content, post_tags,
          post_comment_count, post_status) ";
          $query.= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(),
          '{$post_image}', '{$post_content}', '{$post_tags}', $post_comment_count,'{$post_status}')";

          $create_post_query=mysqli_query($connection, $query);

          confirm($create_post_query);

        break;


    }
  }
}


 ?>

<form class="" action="" method="post">

  <table class="table table-bordered table-hover">




    <div id="bulkOptionsContainer" class="col-lg-4">

      <select class="form-control" name="bulk_options">
        <option value="">Select Options</option>
        <option value="published">Publish</option>
        <option value="draft">Draft</option>
        <option value="delete">Delete</option>
        <option value="clone">Clone</option>

      </select>


    </div>

    <div class="col-lg-4" >
      <input type="submit" name="submit" class="btn btn-primary" value="Apply">
      <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
    </div>

  </table>



<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th><input type="checkbox" class="selectAllBoxes" > </th>
      <th>ID</th>
      <th>Author</th>
      <th>Title</th>
      <th>Category</th>
      <th>Status</th>
      <th>Image</th>
      <th>Tags</th>
      <th>Comments</th>
      <th>Date</th>
      <th>View Post</th>
      <th>Edit</th>
      <th>Delete</th>
      <th>Views</th>

    </tr>
  </thead>

  <tbody>

    <?php
    $query="SELECT * FROM posts  ORDER BY post_id DESC";
    $select_posts= mysqli_query($connection,$query);

    while($row=mysqli_fetch_assoc($select_posts))
    {
      $post_id=$row['post_id'];
      $post_category_id=$row['post_category_id'];
      $post_title=$row['post_title'];
      $post_author=$row['post_author'];
      $post_date=$row['post_date'];
      $post_image=$row['post_image'];
      $post_content=$row['post_content'];
      $post_tags=$row['post_tags'];
      $post_comment_count=$row['post_comment_count'];
      $post_status=$row['post_status'];
      $post_views_count=$row['post_views_count'];

        echo "<tr>";
      ?>

      <td> <input type="checkbox" class="checkBoxes" name="checkBoxArray[]" value="<?php echo $post_id; ?>"> </td>
      <?php


      echo "<td> $post_id  </td>";
      echo "<td>   $post_author  </td>";
      echo "<td> $post_title  </td>";

      $query="SELECT * FROM category WHERE cat_id= {$post_category_id}";
      $cat_query=mysqli_query($connection,$query);

      while($row=mysqli_fetch_assoc($cat_query))
      {
        $cat_id=$row['cat_id'];
        $cat_title=$row['cat_title'];
      }



      echo "<td> $cat_title  </td>";
      echo "<td> $post_status  </td>";
      echo "<td> <img width='100' class='img-responsive' src='../images/$post_image'> </td>";
      echo "<td>  $post_tags </td>";

      // $query="SELECT * FROM comments WHERE comment_post_id=$post_id";
      // $send_comment_query=mysqli_query($connection,$query);
      // $row1=mysqli_fetch_array($send_comment_query);
      // $comment_id=$row1['comment_id'];

        echo "<td>  <a href='post_comments.php?id=$post_id'> $post_comment_count </a></td>";
          echo "<td>   $post_date  </td>";
            echo "<td> <a href='../post.php?p_id=$post_id'>View Post </a> </td>";
            echo "<td> <a href='posts.php?source=edit_post&p_id=$post_id'>Edit </a> </td>";
          echo "<td> <a href='posts.php?delete=$post_id'>Delete </a> </td>";
          echo "<td> $post_views_count  </td>";
          echo "<td> <a href='posts.php?reset=$post_id'>Reset </a> </td>";
      echo "</tr>";





    }





     ?>

     </form>


     <?php

     if(isset($_GET['delete']))
     {
       $post_id=$_GET['delete'];

       $query="DELETE FROM posts WHERE post_id={$post_id}";
       $delete_query=mysqli_query($connection,$query);
       confirm($delete_query);

       header("location: posts.php");
     }


      ?>


      <?php

      if(isset($_GET['reset']))
      {
        $post_id=$_GET['reset'];

        $query="UPDATE posts SET post_views_count=0 WHERE post_id={$post_id}";
        $delete_query=mysqli_query($connection,$query);
        confirm($delete_query);

        header("location: posts.php");
      }


       ?>



    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>

    </tr>
  </tbody>
</table>
