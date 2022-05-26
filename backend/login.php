<?php 
include "header.php";
session_start(); 
error_reporting(E_ERROR | E_PARSE);
if((isset($_SESSION['adminloggedin'])) || isset($_SESSION['loggedin']))
{
    header("location: index.php");  
}
?>
<div class="container">
    <div class="login-page">
        <form method="POST">
            <label>Username</label>
            <input class="form-control" name="user" type="text" placeholder="Username">
            <label>Password</label>
            <input class="form-control" name="password" type="password" placeholder="Password">
            <input type="submit" value="Login" class="btn btn-success" name="login">
        </form>
    </div>
</div>
<?php 
if(isset($_POST['login']))
{
    $user = $_POST['user'];
    $password = $_POST['password'];
    if ($user == 'admin' and $password == 'password'){
    	$_SESSION['adminloggedin']="Login Successfull!";
    	echo '<script>document.location="index.php"</script>';
    	exit();
    }

    $query = $con->query("SELECT * from users where user = '$user' or email = '$user' AND password='$password' AND role='admin'");
    $count= mysqli_num_rows($query);
    if($count == 1)
    {
       $row= mysqli_fetch_assoc($query);
       $_SESSION['loggedin']  = $row['id'];
         echo '<script>alert("Login Successful!");document.location="index.php"</script>';
         exit();
    }
     else{
         echo '<script>alert("Login Failed!");document.location="login.php"</script>';
         exit();
     }
 }  
?>