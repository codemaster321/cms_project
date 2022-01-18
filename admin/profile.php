<?php include "includes/header.php"; ?>

<?php

if(isset($_SESSION['username']))
{
  //Fetching user data and putting in the form
  $username=$_SESSION['username'];
  $query="SELECT * FROM users WHERE username='{$username}'";
  $select_user_profile=mysqli_query($connection,$query);
  confirm($select_user_profile);

  while($row=mysqli_fetch_assoc($select_user_profile))
  {
    $user_firstname=$row['user_firstname'];
    $user_lastname=$row['user_lastname'];
    $username=$row['username'];
    $user_role=$row['user_role'];
    $user_email=$row['user_email'];
    $user_password=$row['user_password'];
  }



}
 ?>


 <?php

 if(isset($_POST['edit_user']))
 {
   $user_firstname=$_POST['user_firstname'];
   $user_lastname=$_POST['user_lastname'];
   $username=$_POST['username'];
   $user_role=$_POST['user_role'];
   $user_email=$_POST['user_email'];
   $user_password=$_POST['user_password'];

   $query= "UPDATE users SET ";
   $query.="user_firstname='{$user_firstname}',";
   $query.="user_lastname='{$user_lastname}',";
   $query.="username='{$username}',";
   $query.="user_role='{$user_role}',";
   $query.="user_email='{$user_email}',";
   $query.="user_password='{$user_password}'";
   $query.=" WHERE username= '{$username}' ";
   $edit_user_query=mysqli_query($connection, $query);

   confirm($edit_user_query);

 }





  ?>



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

                    <form class="" action="" method="post" enctype="multipart/form-data">

                      <div class="form-group">

                        <label for="user_firstname"> Firstname </label>
                        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">

                      </div>

                      <div class="form-group">

                        <label for="user_lastname"> Lastname </label>
                        <input class="form-control" type="text" name="user_lastname" value="<?php echo $user_lastname; ?>">

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
                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">

                      </div>

                      <div class="form-group">

                        <label for="user_email"> Email </label>
                        <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">

                      </div>

                      <div class="form-group">

                        <label for="user_password"> Password </label>
                        <input type="password" class="form-control" name="user_password" value="<?php echo   $user_password; ?>">

                      </div>



                      <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">

                      </div>

                    </form>




                  </div>
              </div>
              <!-- /.row -->

          </div>
          <!-- /.container-fluid -->

      </div>
      <!-- /#page-wrapper -->

      <?php include "includes/footer.php"; ?>
