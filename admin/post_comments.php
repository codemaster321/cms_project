<?php include "includes/header.php"; ?>



      <div id="page-wrapper">
        <?php include "includes/navigation.php"; ?>


          <div class="container-fluid">

              <!-- Page Heading -->
              <div class="row">
                  <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to the comments
                        <small><?php echo $_SESSION['username']; ?></small>
                    </h1>
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Author</th>
      <th>Comment</th>
      <th>Email</th>
      <th>Status</th>
      <th>In Response to</th>
      <th>Date</th>
      <th>Approve</th>
      <th>Unapprove</th>
      <th>Delete</th>

    </tr>
  </thead>

  <tbody>

    <?php
    $chid=$_GET['id'];
    $query="SELECT * FROM comments WHERE comment_post_id=".mysqli_real_escape_string($connection,$chid)."";
    $select_comments= mysqli_query($connection,$query);

    while($row=mysqli_fetch_assoc($select_comments))
    {
      $comment_id=$row['comment_id'];
      $comment_post_id=$row['comment_post_id'];
      $comment_author=$row['comment_author'];
      $comment_email=$row['comment_email'];
      $comment_content=$row['comment_content'];
      $comment_status=$row['comment_status'];
      $comment_date=$row['comment_date'];


      echo "<tr>";
      echo "<td> $comment_id  </td>";
      echo "<td>   $comment_author  </td>";
      echo "<td> $comment_content  </td>";

      // $query="SELECT * FROM category WHERE cat_id= {$post_category_id}";
      // $cat_query=mysqli_query($connection,$query);
      //
      // while($row=mysqli_fetch_assoc($cat_query))
      // {
      //   $cat_id=$row['cat_id'];
      //   $cat_title=$row['cat_title'];
      // }





      // echo "<td> $cat_title  </td>";
      echo "<td> $comment_email </td>";
      echo "<td> $comment_status </td>";
      $query="SELECT * FROM posts WHERE post_id={$comment_post_id}";
      $fetch_query=mysqli_query($connection,$query);
      while($row=mysqli_fetch_assoc($fetch_query))
      {
        $post_id=$row['post_id'];
        $post_title=$row['post_title'];
        echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
      }


      echo "<td> $comment_date </td>";
      echo "<td> <a href='comments.php?approve=$comment_id'>Approve </a> </td>";
      echo "<td> <a href='comments.php?unapprove=$comment_id'>Unapprove </a> </td>";
      // echo "<td> <a href='comments.php?source=edit_post&p_id=$comment_id'>Edit </a> </td>";
      echo "<td> <a href='post_comments.php?delete=$comment_id&id=".$_GET['id']."'>Delete </a> </td>";

      echo "</tr>";





    }



     ?>


     <?php

     if(isset($_GET['delete']))
     {
       $comment_id=$_GET['delete'];

       $query="SELECT * FROM comments WHERE comment_id=$comment_id";
       $select_comments= mysqli_query($connection,$query);

       while($row=mysqli_fetch_assoc($select_comments))
       {
         $comment_post_id=$row['comment_post_id'];
       }


       $delete_count="UPDATE posts SET post_comment_count=post_comment_count-1 WHERE post_id=$comment_post_id";
       $delete_count_query=mysqli_query($connection,$delete_count);
       confirm($delete_count_query);

       $query="DELETE FROM comments WHERE comment_id={$comment_id}";
       $delete_query=mysqli_query($connection,$query);
       confirm($delete_query);

       header("Location: post_comments.php?id=$chid");
     }

     if(isset($_GET['unapprove']))
     {
       $comment_id=$_GET['unapprove'];
       $query="UPDATE comments SET comment_status='unapproved' WHERE comment_id={$comment_id}";
       $unapprove_query=mysqli_query($connection,$query);
       confirm($unapprove_query);

       header("location: comments.php");
     }

     if(isset($_GET['approve']))
     {
       $comment_id=$_GET['approve'];
       $query="UPDATE comments SET comment_status='approved' WHERE comment_id={$comment_id} ";
       $approve_query=mysqli_query($connection,$query);
       confirm($approve_query);

       header("location: comments.php");
     }




      ?>



    <!-- <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>

    </tr> -->
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
