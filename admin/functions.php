
<?php




function users_online()
{

  if(isset($_GET['usersonline']))
  {
  global $connection;
  if(!$connection)
  {
    session_start();
    include("../includes/db.php");

    $session=session_id();
    $time=time();
    $time_out_in_seconds=60;
    $time_out=$time-$time_out_in_seconds;

    $query="SELECT * FROM users_online WHERE session='$session' ";
    $session_query=mysqli_query($connection,$query);
    $count=mysqli_num_rows($session_query);

    if($count==NULL)
    {
      mysqli_query($connection,"INSERT INTO users_online(session, time) VALUES('$session','$time')" );

    }

    else
    {
      mysqli_query($connection,"UPDATE users_online SET time='$time' WHERE session='$session'");

    }


    $users_online_query=mysqli_query($connection,"SELECT * FROM users_online WHERE time> '$time_out'");
    $count=mysqli_num_rows($users_online_query);
    echo $count;




  }


    }
}

users_online();




function insert_categories()
{
  global $connection;

  if(isset($_POST['submit']))
  {
    $cat_title=$_POST['cat_title'];

    if($cat_title=="" || empty($cat_title))
      echo "This isnt to be left empty bitch";

      else
        {
          $stmt=mysqli_prepare($connection,"INSERT INTO category(cat_title) VALUES(?)");
          mysqli_stmt_bind_param($stmt,"s",$cat_title);
          mysqli_stmt_execute($stmt);

          if(!$stmt)
          {
            die("Error :".mysqli_error($connection));
          }




        }

  }

}

function findAllCategories()
{
  global $connection;

  $query="SELECT * FROM category";
  $select_categories=mysqli_query($connection,$query);

  while($row=mysqli_fetch_assoc($select_categories))
  {
    $cat_id=$row['cat_id'];
    $cat_title=$row['cat_title'];

    //Fetching the data in table
    echo " <tr> ";
  echo "<td> {$cat_id}  </td>";
  echo "<td> {$cat_title}  </td>";
  echo " <td><a href='categories.php?delete={$cat_id}'>Delete</a></td> ";
    echo " <td><a href='categories.php?edit={$cat_id}'>Edit</a></td> ";

  echo " </tr>";

  }




}


function deleteCategories()
{
global $connection;

  if(isset($_GET['delete']))
  {
    $delete=$_GET['delete'];
    $query= "DELETE FROM category WHERE cat_id={$delete}";
    $delete_query=mysqli_query($connection,$query);

    header("Location: categories.php");

  }

}

function recordCount($table)
{
  global $connection;

  $query="SELECT * FROM ". $table;
  $select_all_posts= mysqli_query($connection,$query);
  $result=mysqli_num_rows($select_all_posts);
  confirm($result);
  return $result;

}



function confirm($result)
{
  global $connection;

  if(!$result)
  {
    die("Query failed ".mysqli_error($connection));
  }
}

function is_admin($username='')
{
  global $connection;

  $query="SELECT user_role FROM users WHERE username='$username'";
  $admin_query=mysqli_query($connection,$query);
  confirm($admin_query);
  $row=mysqli_fetch_array($admin_query);
  if($row['user_role']=='admin')
  {
    return true;
  }
  else return false;
}

function username_exists($username)
{
  global $connection;

  $query="SELECT username FROM users WHERE username='$username'";
  $result=mysqli_query($connection,$query);
  confirm($result);

  if(mysqli_num_rows($result)>0)
    return true;
  else
      return false;
}

function email_exists($user_email)
{
  global $connection;

  $query="SELECT user_email FROM users WHERE user_email='$user_email' ";
  $result=mysqli_query($connection,$query);
  confirm($result);

  if(mysqli_num_rows($result)>0)
    return true;
  else
      return false;
}



function register_user($username,$email,$password)
{
  global $connection;



  if(!empty($username) && !empty($password) && !empty($email))
  {
  $username=mysqli_real_escape_string($connection,$username);
  $password=mysqli_real_escape_string($connection,$password);
  $email=mysqli_real_escape_string($connection,$email);


  $password= password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

  $query="INSERT INTO users(username,user_password,user_email,user_role) ";
  $query.="VALUES('$username','$password','$email','subscriber')";
  $register_user_query=mysqli_query($connection,$query);
  if(!$register_user_query)
  {
  die("Query Failed ".mysqli_error($connection));
  }
  global $message;
   $message= "Your registration has been submitted";
   header("Location: admin");
    }
  else
  {
    global $message;
  $message= "Fill it again";
  }

}


  function query($query)
  {
    global $connection;
   return mysqli_query($connection,$query);
  }


  function loggedInUserID()
  {
    if(isLoggedin())
    {
      $query=query("SELECT * FROM users WHERE username='". $_SESSION['username']. "'");
      $row=mysqli_fetch_assoc($query);
      if(mysqli_num_rows($query)>=1)
      {
        return $row['user_id'];
      }
    }

    return false;
  }

  function userLikedThisPost($post_id='')
  {
    $query=query("SELECT * FROM likes WHERE user_id=".loggedInUserID()." AND post_id=$post_id");
    return mysqli_num_rows($query) >= 1 ? true : false;
  }







function login_user($username,$password)
{
  global $connection;

  $username=trim($username);
  $password=trim($password);

   $username= mysqli_real_escape_string($connection,$username);
   $password= mysqli_real_escape_string($connection,$password);

   $query="SELECT * FROM users WHERE username='{$username}' ";
   $select_query=mysqli_query($connection,$query);
   while($row=mysqli_fetch_assoc($select_query))
   {
    $db_user_id =$row['user_id'];
    $db_username =$row['username'];
    $db_user_firstname =$row['user_firstname'];
    $db_user_lastname =$row['user_lastname'];
    $db_user_role =$row['user_role'];
    $db_password=$row['user_password'];
   }






   if(password_verify($password,$db_password) || $password===$db_password)
   {
     $_SESSION['username']= $db_username;
     $_SESSION['firstname']= $db_user_firstname;
     $_SESSION['lastname']= $db_user_lastname;
     $_SESSION['user_role']= $db_user_role;
     header("Location: /cms/admin");
   }
   else header("Location: /cms/index");

}

function ifItIsMethod($method=null)
{
  if($_SERVER['REQUEST_METHOD']==strtoupper($method))
  {
    return true;
  }
  return false;
}

function isLoggedin()
{
  if(isset($_SESSION['user_role']))
  {
    return true;
  }

  return false;
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null)
{
  if(isLoggedin())
  {
    redirect($redirectLocation);
  }
}

function redirect($location)
{
  header("Location".$location);
  exit;
}


function getPostLikes($post_id)
{
  $query=query("SELECT * FROM likes WHERE post_id=$post_id");
  confirm($query);
  return mysqli_num_rows($query);
}



?>
