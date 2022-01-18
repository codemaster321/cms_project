<?php

  if(isset($_POST['create_user']))
  {
    $user_firstname=$_POST['user_firstname'];
    $user_lastname=$_POST['user_lastname'];
    $username=$_POST['username'];
    $user_role=$_POST['user_role'];
    $user_email=$_POST['user_email'];
    $user_password=$_POST['user_password'];

$user_password= password_hash($user_password, PASSWORD_BCRYPT, array('cost'=>10));

    $query= "INSERT INTO users(user_firstname, user_lastname, user_role,username,user_email, user_password) ";
    $query.= "VALUES('{$user_firstname}', '{$user_lastname}', '{$user_role}',
    '{$username}', '{$user_email}', '{$user_password}')";

    $create_user_query=mysqli_query($connection, $query);

    confirm($create_user_query);

    echo "User Inserted" .":"."<a href='users.php'>Users</a>";

  }



 ?>






<form class="" action="" method="post" enctype="multipart/form-data">

  <div class="form-group">

    <label for="user_firstname"> Firstname </label>
    <input type="text" class="form-control" name="user_firstname" value="">

  </div>

  <div class="form-group">

    <label for="user_lastname"> Lastname </label>
    <input class="form-control" type="text" name="user_lastname" value="">

  </div>

  <!-- <div class="form-group">

    <label for="post_category"> Post Category Id </label>
    <input type="text" class="form-control" name="post_category_id" value="">

  </div> -->

  <div class="form-group">

    <select class="" name="user_role">
      <option value="admin">Select Options</option>
      <option value="admin">Admin</option>
      <option value="subscriber">Subscriber </option>

    </select>

  </div>





  <div class="form-group">

    <label for="username"> Username </label>
    <input type="text" class="form-control" name="username" value="">

  </div>

  <div class="form-group">

    <label for="user_email"> Email </label>
    <input type="email" class="form-control" name="user_email" value="">

  </div>

  <div class="form-group">

    <label for="user_password"> Password </label>
    <input type="password" class="form-control" name="user_password" value="">

  </div>



  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="create_user" value="Add User">

  </div>






</form>
