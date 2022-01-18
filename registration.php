 <?php  include "includes/header.php"; ?>

<?php include "admin/functions.php" ?>
    <!-- Navigation -->

    <?php  include "includes/navigation.php"; ?>


    <?php
    $message=NULL;

    if(isset($_POST['submit']))
    {
      $username=trim($_POST['username']);
      $password=trim($_POST['password']);
      $email=trim($_POST['email']);

      $error=[
        'username'=>'',
        'email'=>'',
        'password'=>''
      ];

      if(strlen($username)< 4)
      {
        $error['username']='Username needs to be longer';
      }

      if(strlen($username) == '')
      {
        $error['username']='Username needs to have something';
      }

      if(username_exists($username))
      {
        $error['username']= 'Username already exists';
      }

      if($email=='')
      {
        $error['email']= 'Email cant be empty';
      }

      if(email_exists($email))
      {
        $error['email']= 'Email already exists';
      }

      if($password=='')
      {
        $error['password']= 'Password cant be empty';
      }


      foreach($error as $key => $value)
      {
        if(empty($value))
        {
          unset($error[$key]);
        }


      }

      if(empty($error))
      {
        register_user($username,$email,$password);
        login_user($username,$password);
      }


    }



     ?>


    <!-- Page Content -->
    <div class="container">

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" >
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($username)? $username : ''  ?>">
                            <p><?php echo isset($error['username'])? $error['username'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on"
                            value="<?php echo isset($email)? $email : ''  ?>">
                            <p><?php echo isset($error['email'])? $error['email'] : '' ?></p>

                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <p><?php echo isset($error['password'])? $error['password'] : '' ?></p>

                        </div>

                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>

                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
