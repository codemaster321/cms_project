<div class="col-md-4">

<?php


if(ifItIsMethod('post'))
{
  if(isset($_POST['login']))
  {

  if(isset($_POST['username']) && isset($_POST['password']))
  {
    login_user($_POST['username'],$_POST['password']);
  }
  else
    redirect('/cms/index');

  }
}

 ?>


    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form  action="search.php" method="post">
        <div class="input-group">
            <input name="search" type="text" class="form-control">
            <span class="input-group-btn">
                <button name="submit" class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
        </div>
        </form>
        <!-- /.input-group -->
    </div>


    <!-- Login -->
    <div class="well">
      <?php if(isset($_SESSION['user_role'])): ?>
        <h4>Logged in as <?php echo $_SESSION['username'] ?></h4>
        <a href="includes/logout.php" class="btn btn-primary">Logout</a>
      <?php else: ?>
        <h4>Login</h4>
        <form   method="post">
        <div class="form-group">
            <input name="username" type="text" class="form-control" placeholder="Enter Username">
        </div>

        <div class="input-group">
          <input type="password" name="password" class="form-control" placeholder="Enter Password">
          <span class="input-group-btn">
            <button class="btn btn-danger" type="submit" name="login">Submit</button>

          </span>
        </div>

        <div class="form-group">
          <a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Passwprd?</a>

        </div>

        </form>

      <?php endif; ?>




        <!-- /.input-group -->
    </div>




    <!-- Blog Categories Well -->
    <div class="well">

        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                  <?php
                  $query="SELECT * FROM category LIMIT 3";
                  $select_all_categories= mysqli_query($connection,$query);

                    while($row=mysqli_fetch_assoc($select_all_categories))
                    {
                      $cat_title=$row['cat_title'];
                      $cat_id=$row['cat_id'];
                      echo "<li><a href='/cms/category/{$cat_id}'>{$cat_title}</a></li>";


                    }
                   ?>


                </ul>
            </div>
            <!-- /.col-lg-6 -->
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
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <div class="well">
        <h4>Side Widget Well</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
    </div>

</div>
