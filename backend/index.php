<?php 
include "header.php";
session_start(); 
error_reporting(E_ERROR | E_PARSE);
if((!isset($_SESSION['adminloggedin'])) && !isset($_SESSION['loggedin']))
{
    header("location: login.php");  
}
?>
<div class="container">
    <div class="logout float-end">
        <a class="btn btn-danger" href="logout.php">LogOut</a>
    </div>
    <div class="row">
        <?php if(isset($_SESSION['adminloggedin'])){ ?>
        <div class="col-md-6">
            <div class="login-page">
                <form method="POST">
                    <span id="adminerr"></span><br>
                    <label>Name</label>
                    <input class="form-control" name="name" id="adminname" type="text" onchange="checkValidation('admin')" placeholder="Name">
                    <label>Email</label>
                    <input class="form-control" name="email" id="adminemail" type="email" onchange="checkValidation('admin')" placeholder="Email">
                    <label>Username</label>
                    <input class="form-control" name="user" id="adminuser" type="text" onchange="checkValidation('admin')" placeholder="Username">
                    <label>Password</label>
                    <input class="form-control" name="password" id="adminpassword" type="password" onchange="checkValidation('admin')" placeholder="Password">
                    <label>Phone Number</label>
                    <input class="form-control" name="phone" id="adminphone" type="numbers" onchange="checkValidation('admin')" placeholder="Phone">
                    <input class="form-control" name="role" value="admin" type="hidden"> 
                    <!-- We can use this as dropdown to -->
                    <input type="button" value="Add Admin" id="admin" onclick="checkValidation('admin', 1)" class="btn btn-success" id="addad" name="addad">
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="login-page">
                <form method="POST">
                    <span id="usererr"></span><br>
                    <label>Name</label>
                    <input class="form-control" name="name" id="username" type="text" onchange="checkValidation('user')" placeholder="Name">
                    <label>Email</label>
                    <input class="form-control" name="email" id="useremail" type="email" onchange="checkValidation('user')" placeholder="Email">
                    <label>Username</label>
                    <input class="form-control" name="user" id="useruser" type="text" onchange="checkValidation('user')" placeholder="Username">
                    <label>Password</label>
                    <input class="form-control" name="password" id="userpassword" type="password" onchange="checkValidation('user')" placeholder="Password">
                    <label>Phone Number</label>
                    <input class="form-control" name="phone" id="userphone" type="numbers" onchange="checkValidation('user')" placeholder="Phone">
                    <input class="form-control" name="role" value="user" type="hidden"> 
                    <!-- We can use this as dropdown to -->
                    <input type="button" value="Add User" id="user" onclick="checkValidation('user', 1)" class="btn btn-success" name="addus">
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Name</td>
                        <td>User</td>
                        <td>Email</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i=0;
                    $q1 = mysqli_query($con,"select * from users where role='admin'");
                    while($r1 = mysqli_fetch_assoc($q1)){
                        $i++;
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $r1['name'];?></td>
                        <td><?php echo $r1['user'];?></td>
                        <td><?php echo $r1['email'];?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
        <?php 
         if(isset($_SESSION['adminloggedin'])){ 
        ?>
        <div class="col-md-6">
        <?php }else{ ?>
        <div class="col-md-12">
        <?php } ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Name</td>
                        <td>User</td>
                        <td>Email</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i=0;
                    $q1 = mysqli_query($con,"select * from users where role='user'");
                    while($r1 = mysqli_fetch_assoc($q1)){
                        $i++;
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $r1['name'];?></td>
                        <td><?php echo $r1['user'];?></td>
                        <td><?php echo $r1['email'];?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function getValue(asset, id){
    var id = document.getElementById(asset+id).value;
    if ((id == "")){
        return false;
    }else{
        return id;
    }
}
function getEmail(asset, id){
    var id = document.getElementById(asset+id).value;
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(id)){
        return id;
    }else{
        return false
    }
}
function checkPass(asset, id){
    var id = document.getElementById(asset+id).value;
    if(id.length >= 8){
        return id
    }else{
        return false
    }
}
function checkValidation(asset, click){
    var name = getValue(asset, 'name');
    var email = getEmail(asset, 'email');
    var user = getValue(asset, 'user');
    var password = checkPass(asset, 'password');
    var phone = getValue(asset, 'phone');

    if(name != false && email != false && user != false && password != false && phone != false){
        document.getElementById(asset).type="submit"; 
    }else{
        document.getElementById(asset).type="button"; 
    }

    if(name == false || email == false || user == false || password == false || phone == false && click){
        document.getElementById(asset+"err").innerHTML="Please fill all the fields"; 
    }else{
        document.getElementById(asset+"err").innerHTML=""; 
    }
}
</script>
<?php 
if(isset($_POST['addad']))
{
    $name = $_POST['name'];
    $user = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['password'];// You can encode password with md5 or sha1 or any other 
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    if(empty($name) || empty($user) || empty($email) || empty($password) || empty($phone)){
        echo '<script>alert("Please fill all the fields");document.location="index.php"</script>';
    }

    $query = $con->query("insert into users(`name`,`user`,`password`,`email`,`phone`,`role`)values('".$name."','".$user."','".$password."','".$email."','".$phone."','".$role."')");
    if($query){
    	echo '<script>alert("Admin Has Been Added");document.location="index.php"</script>';
    }else{
    	echo '<script>alert("Something went wrong");document.location="index.php"</script>';
    }
}
if(isset($_POST['addus']))
{
    $name = $_POST['name'];
    $user = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    if(empty($name) || empty($user) || empty($email) || empty($password) || empty($phone)){
        echo '<script>alert("Please fill all the fields");document.location="index.php"</script>';
    }

    $query = $con->query("insert into users(`name`,`user`,`password`,`email`,`phone`,`role`)values('".$name."','".$user."','".$password."','".$email."','".$phone."','".$role."')");
    if($query){
    	echo '<script>alert("User Has Been Added");document.location="index.php"</script>';
    }else{
    	echo '<script>alert("Something went wrong");document.location="index.php"</script>';
    }
 }  
?>