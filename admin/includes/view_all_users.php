<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
      <th>Role</th>
      <th>Delete</th>

    </tr>
  </thead>

  <tbody>

    <?php
    $query="SELECT * FROM users";
    $select_posts= mysqli_query($connection,$query);

    while($row=mysqli_fetch_assoc($select_posts))
    {
      $user_id=$row['user_id'];
      $username=$row['username'];
      $user_password=$row['user_password'];
      $user_firstname=$row['user_firstname'];
      $user_lastname=$row['user_lastname'];
      $user_email=$row['user_email'];
      $user_image=$row['user_image'];
      $user_role=$row['user_role'];

      echo "<tr>";
      echo "<td> $user_id  </td>";
      echo "<td>     $username  </td>";
      echo "<td>   $user_firstname  </td>";
    //    echo "<td> $user_date  </td>";

      // $query="SELECT * FROM category WHERE cat_id= {$post_category_id}";
      // $cat_query=mysqli_query($connection,$query);
      //
      // while($row=mysqli_fetch_assoc($cat_query))
      // {
      //   $cat_id=$row['cat_id'];
      //   $cat_title=$row['cat_title'];
      // }



      echo "<td>   $user_lastname  </td>";
      echo "<td> $user_email  </td>";
        echo "<td> $user_role  </td>";

      // echo "<td> <img width='100' class='img-responsive' src='../images/$post_image'> </td>";
      // echo "<td>  $post_tags </td>";
      //   echo "<td>   $post_comment_count  </td>";
      //     echo "<td>   $post_date  </td>";
            echo "<td> <a href='users.php?source=edit_user&edit_user=$user_id'>Edit </a> </td>";
          echo "<td> <a href='users.php?admin=$user_id'>Admin </a> </td>";
          echo "<td> <a href='users.php?subscriber=$user_id'>Subscriber </a> </td>";
          echo "<td> <a href='users.php?delete=$user_id'>Delete </a> </td>";

      echo "</tr>";





    }



     ?>


     <?php

     if(isset($_GET['delete']))
     {
       if(isset($_SESSION['user_role']))
       {


       if($_SESSION['user_role']=='admin')
        {
       $user_id=mysqli_real_escape_string($connection,$_GET['delete']);
       $query="DELETE FROM users WHERE user_id={$user_id}";
       $delete_query=mysqli_query($connection,$query);
       confirm($delete_query);

       header("location: users.php");
        }
      }
     }

     if(isset($_GET['admin']))
     {
       $admin=$_GET['admin'];
       $query="UPDATE users SET user_role='admin' WHERE user_id={$admin}";
       $admin_query=mysqli_query($connection,$query);
       confirm($admin_query);

       header("location: users.php");
     }

     if(isset($_GET['subscriber']))
     {
       $subscriber=$_GET['subscriber'];
       $query="UPDATE users SET user_role='subscriber' WHERE user_id={$subscriber} ";
       $subscriber_query=mysqli_query($connection,$query);
       confirm($subscriber_query);

       header("location: users.php");
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
