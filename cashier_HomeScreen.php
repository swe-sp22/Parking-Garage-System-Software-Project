<!doctype html>
<html lang="en">

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Cashier HomeScreen</title>
</head>
<?php
    session_start();
        $cashier_name = $_SESSION['first_name'];
        $servername = "localhost";
        $database = "ParkingGarageSystem";
        $user = "root";
        $password = "";

        $conn = mysqli_connect($servername, $user, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query1 = "SELECT * FROM cashier WHERE first_name='$cashier_name'";
        $queryRes=mysqli_query($conn,$query1);
        $fetch = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);

        if($fetch>0)
        {
            $garage_id = $fetch['garageID'];
            $_SESSION['garage_id'] = $garage_id;
            $_SESSION['cashier_id'] = $fetch['cashier_id'];
            $query2 = "SELECT * FROM garage WHERE garage_id='$garage_id'";
            $queryRes=mysqli_query($conn,$query2);
            $fetch2 = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
            if($fetch2>0){
                $branch=$fetch2['garage_name'];
            }else{
                echo "error1";
                $errorMsg = "Error1";
                echo '<script type="text/javascript">alert("INFO:  '.$errorMsg.'");</script>';
            }
            /*while($fetch)
            {
                if($pwd == $fetch['garage']){
                    echo "here2";
                    $branch=$fetch['first_name'];
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
            }*/
        } else {
            echo "error2";
            $errorMsg = "Error2";
            //echo '<script type="text/javascript">alert("INFO:  '.$errorMsg.'");</script>';
            //echo '<div style = "margin-top: 105px;" class="alert alert-danger alert-dismissible fade show" role="alert">
                //   <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                //   Incorrect username or password
                //   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                //   </div>';
        }
    mysqli_close($conn);
?>

<body style="background-image: url('cashierbackground1.jpg');height: 100%; background-repeat: no_repeat; background-size: cover;">
<h1 style="color: rgb(255, 255, 255); text-align: center; margin-top: 15px;"><b><i><?php echo htmlspecialchars($branch);?> Parking System</i></b></h1>
<h2 style="color: rgb(255, 255, 255); text-align: center;"><?php echo htmlspecialchars($cashier_name);?> Screen</h2>
<div class="row">
  <div class="column">
    <button type="button" class="button"; onclick="window.location.href='cashier_EntryScreen.php';">Log customer In</button>
  </div>
  <div class="column">
    <button type="button" class="button" onclick="window.location.href='cashier_ExitScreen.php';">Log customer Out</button>
  </div>
</div>
</body>  

<style>
    * {
        box-sizing: border-box
    }
    .button{
        background-color: #dcb124;
        display: block;
        margin: 80px 370px;
        padding: 10px;
        width: 320px;
        border: 5px solid black;
        cursor: pointer;
    }
    .column {
    float: left;
    width: 33.33%;
    }

    .row:after {
    content: "";
    display: table;
    clear: both;
    }
</style>
</html>