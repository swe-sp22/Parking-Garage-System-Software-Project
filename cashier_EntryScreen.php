<!doctype html>
<html lang="en">

<head>
    <title>customer entry log</title>
</head>
<?php
    session_start();
            $servername = "localhost";
            $database = "ParkingGarageSystem";
            $user = "root";
            $password = "";
            $cashierID = $_SESSION['cashier_id'];
            $garageID = $_SESSION['garage_id'];
            
            $conn = mysqli_connect($servername, $user, $password, $database);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            //date_default_timezone_set("Africa/Cairo");
            //$todayDate = date("Y-m-d");
            //echo "$todayDate";
            //echo "<script>current.toLocaleDateString</script>";
            if(isset($_POST['submit'])) {
                //$todayDate = current.toLocaleDateString();
                //echo "<script>current.toLocaleDateString</script>";
                if($_POST['licenseNo']){
                    $license_No = $_POST['licenseNo'];
                    if(isset($_POST['checkbox'])){
                        $query1 = "SELECT * FROM customer NATURAL JOIN customer_reservation WHERE customer.license_no='$license_No';";
                        $queryRes=mysqli_query($conn,$query1);
                        $fetch = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                        if ($fetch > 0){
                            $query2 = "INSERT INTO current_customers(entry_cashier_id, license_no, garage_id) VALUES ($cashierID, $license_No, $garageID);";
                            $queryRes=mysqli_query($conn,$query2);
                            header('location: cashier_HomeScreen.php');
                        }else{
                            echo "<script>alert('Error: No reservation made');window.location.href='cashier_EntryScreen.php'</script>";
                        }
                    }else{
                        //$query3 = "SELECT COUNT(*) as count FROM customer_reservation WHERE entry_time LIKE '$todayDate%';";
                        //$queryRes=mysqli_query($conn,$query3);
                        //$temp = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                        //$noOfReserved = $temp['count'];
                        $query4 = "SELECT * FROM garage WHERE garage_id = '$garageID';";
                        $queryRes=mysqli_query($conn,$query4);
                        $this_garage = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                        $availableSpots = $this_garage['ava_spots'];
                        //$freeSpots = $availableSpots - $noOfReserved;
                        if($availableSpots > 0){
                            $query5 = "INSERT INTO current_customers(entry_cashier_id, license_no, garage_id) VALUES ($cashierID, $license_No, $garageID);";
                            $queryRes=mysqli_query($conn,$query5);
                            $new_availableSpots = $availableSpots - 1;
                            $query6 = "UPDATE `garage` SET `ava_spots` = '$new_availableSpots' WHERE `garage`.`garage_id` = $garageID";
                            $queryRes=mysqli_query($conn,$query6);
                            header('location: cashier_HomeScreen.php');
                        }else{
                            echo "<script>alert('Sorry: No free spots available');window.location.href='cashier_EntryScreen.php'</script>";
                        }
                    }
                }else{
                    echo "<script>alert('Error: Please enter license number');window.location.href='cashier_EntryScreen.php'</script>";
                }
            }
?>
<body style="background-image: url('cashierbackground2.jpg'); height: 100%; background-repeat: no_repeat; background-size: auto;">
    <form class="centered" method="post">
        <input class = "inputField" name="licenseNo" placeholder="Enter customer license number" onfocus="if(this.placeholder=='Enter customer license number') this.placeholder='';" onblur="if(this.placeholder=='') this.placeholder='Enter customer license number'"></input>
        <label class="container">Was there a reservation made?
            <input type="checkbox" name="checkbox" checked="checked">
            <span class="checkmark"></span>
        </label>
        <input type="submit" name="submit" value="confirm entry" class="submit-btn"></input>
    </form>
</body>

<style>
    ::placeholder{
        font-size: 16px;
    }
    .centered{
        position: fixed;
        top: 40%;
        left: 34%;
    }
    .inputField{
        width: 280px;
        height: 50px;
        border-radius: 15px;
        background-color: #E8E8E8;
        padding-right: 50px;
        padding-bottom: 50px;
        margin-bottom: 8px;
    }
    .submit-btn{
        position: fixed;
        margin-left: 100px;
        padding: 10px 15px;
        width: 120px;
        background-color: #009925;
        border-radius: 3px;
        border: none;
        cursor: pointer;
        margin-top: 10px;
    }
    /* Customize the label (the container) */
    .container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

/* Hide the browser's default checkbox */
    .container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
    }

/* Create a custom checkbox */
    .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #ccc;
    border-radius:2px;
    }

/* On mouse-over, add a grey background color */
    .container:hover input ~ .checkmark {
    background-color: #eee;
    }

/* When the checkbox is checked, add a blue background */
    .container input:checked ~ .checkmark {
    background-color: #eee;
    }

/* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
    content: "";
    position: absolute;
    display: none;
    }

/* Show the checkmark when checked */
    .container input:checked ~ .checkmark:after {
    display: block;
    }

/* Style the checkmark/indicator */
    .container .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid #2172F3;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
    }
</style>