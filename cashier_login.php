<!doctype html>
<html lang="en">

<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="mystyles.css">
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>
    <title>Login</title>
</head>
         
<?php
$servername = "localhost";
$database = "ParkingGarageSystem";
$user = "root";
$password = "";

// Create connection

$conn = mysqli_connect($servername, $user, $password, $database);

// Check connection

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

session_start();
//$garage_id = $_SESSION['branch_id'];
if(isset($_POST['submit']))
{
 $usr=$_POST['usr'];
 $pwd=$_POST['password'];
 echo $usr;
 $query1 = "SELECT * FROM cashier WHERE username='$usr'";
 $queryRes=mysqli_query($conn,$query1);
 $fetch = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
   echo $fetch;
   
    //$queryadmin = mysqli_query($conn, "SELECT * from admin where username='".$usr."'") or die(mysqli_error());
    //$res=mysqli_fetch_all($query, MYSQLI_ASSOC);
   if($fetch>0)
   {
       while($fetch)
       {
           if($pwd == $fetch['password']){
            echo "here2";
            $_SESSION['first_name']=$fetch['first_name'];
            $_SESSION['customer_id'] = $fetch['cust_id'];
            //$_SESSION['garage_id'] = $garage_id;
            header('location:cashier_HomeScreen.php');
           }
           else {
            echo "here1";
            $errorMsg = "Incorrect username or password";
            // echo '<script type="text/javascript">alert("INFO:  '.$errorMsg.'");</script>';
            //echo '<div style = "margin-top: 105px;" class="alert alert-danger alert-dismissible fade show" role="alert">
                //   <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                //   Incorrect username or password
                //   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                //   </div>';
            }
       }
   }
}

mysqli_close($conn);
?>

<body style="background-image: url('car.jpg');">
<h2 style="text-align: center; margin-top:50px;"><i><b>Please login to proceed</b></i></h2>
<form action="#" name="myForm" method="post" onsubmit="return validateForm()" style="margin-top: 40px;
    margin-left: 500px;
    margin-right: 500px;">
        
        <label  class="form-label">Username</label>
        <div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">@</span>
  <input type="text" name="usr" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
</div>
         <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>

        <div class="center" style="margin-top: 30px">
            <button type="submit" name="submit" value="Submit" class="btn btn-primary">Log in</button>
        </div>

        </form>
        <br>
    <h4 style="text-align: center;">Don't have an account? <a href="index_signup.php">Sign Up!</a></h4>
        <script>   
        function validateForm(){
          var y = document.forms["myForm"]["usr"].value;
          var z = document.forms["myForm"]["password"].value;

          if (y == "") {
            alert("Please enter your username");
            return false;
          }
          if (z == "") {
            alert("Please enter password");
            return false;
          }
        }
    </script>   

</body>  

</html>