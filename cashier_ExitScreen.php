<!doctype html>
<html lang="en" style="height: 100%; width:100%;">

<head>
    <title>Cashier ExitScreen</title>
</head>
<?php
    session_start();
            $servername = "localhost";
            $database = "ParkingGarageSystem";
            $user = "root";
            $password = "";
            $totalFees = 0;
            $feesToPay = 0;
            $feestoReturn = 0;
            $cashierID = $_SESSION['cashier_id'];
            $allow = false;
            
            $conn = mysqli_connect($servername, $user, $password, $database);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            if(isset($_POST['submit'])) {
                if($_POST['licenseNo']){
                    $allow = true;
                    $license_No = $_POST['licenseNo'];
                    if(isset($_POST['polish'])){
                        $query = "SELECT * FROM services WHERE service_name='car_polish';";
                        $queryRes=mysqli_query($conn,$query);
                        $polish = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                        $price = $polish['price_per_unit'];
                        $totalFees = $totalFees + $price;
                    }
                    if(isset($_POST['interior'])){
                        $query = "SELECT * FROM services WHERE service_name='interior_wash';";
                        $queryRes=mysqli_query($conn,$query);
                        $interior = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                        $price = $interior['price_per_unit'];
                        $totalFees = $totalFees + $price;
                    }
                    if(isset($_POST['exterior'])){
                        $query = "SELECT * FROM services WHERE service_name='exterior_wash';";
                        $queryRes=mysqli_query($conn,$query);
                        $exterior = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                        $price = $exterior['price_per_unit'];
                        $totalFees = $totalFees + $price;
                    }
                    if(isset($_POST['tire'])){
                        $query = "SELECT * FROM services WHERE service_name='tire_gauge';";
                        $queryRes=mysqli_query($conn,$query);
                        $tireGauge = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                        $price = $tireGauge['price_per_unit'];
                        $totalFees = $totalFees + $price;
                    }
                    $query1 = "SELECT * FROM current_customers WHERE license_no='$license_No';";
                    $queryRes=mysqli_query($conn,$query1);
                    $customerEntry = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                    if($customerEntry > 0){
                        $query0 = "SELECT * FROM services WHERE service_name='temporary_parking';";
                        $queryRes=mysqli_query($conn,$query0);
                        $tempPark = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                        $hourCost = $tempPark['price_per_unit'];
                        $entryTime = $customerEntry['entry_time'];
                        $entryCashierID = $customerEntry['entry_cashier_id'];
                        $garageID = $customerEntry['garage_id'];
                        date_default_timezone_set("Africa/Cairo");
                        $today = intval(date("d"));
                        $currentTimeStamp = date("Y-m-d H:i:s");
                        $Dayquery = "SELECT EXTRACT(DAY FROM (SELECT `entry_time` FROM current_customers WHERE license_no='$license_No')) as day";
                        $queryRes=mysqli_query($conn,$Dayquery);
                        $days = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                        $entryDay = $days['day'];
                        $hourQuery = "SELECT EXTRACT(HOUR FROM (SELECT `entry_time` FROM current_customers WHERE license_no='$license_No')) as hour";
                        $queryRes=mysqli_query($conn,$hourQuery);
                        $hours = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                        $entryHour = $hours['hour'];
                        if($today != $entryDay){
                            $queryy = "SELECT * FROM services WHERE service_name='overnight_parking';";
                            $queryRes=mysqli_query($conn,$queryy);
                            $overnightPark = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                            $overnightParkCost = $overnightPark['price_per_unit'];
                            $totalFees = $totalFees + ($today - $entryDay)*$overnightParkCost;
                            echo $entryDay;
                            echo $today;
                            echo $overnightParkCost;
                        }else{
                            $timeRn = date("H");
                            $totalFees = $totalFees + ($timeRn - $entryHour + 1)*$hourCost;
                        }
                    }else{
                        echo "<script>alert('Error: This customer was not logged in');window.location.href='cashier_ExitScreen.php'</script>";
                    }
                    $query2 = "SELECT * FROM customer NATURAL JOIN customer_reservation WHERE customer.license_no='$license_No';";
                    $queryRes=mysqli_query($conn,$query2);
                    $customerReservation = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                    if ($customerReservation > 0){
                        $paid = $customerReservation['total_fees'];
                        if($totalFees - $paid > 0){
                            $feesToPay = $totalFees - $paid;
                        }else if($totalFees - $paid < 0){
                            $feestoReturn = $totalFees - $paid;
                        }
                    }else{
                        $feesToPay = $totalFees;
                    }
                }else{
                    echo "<script>alert('Error: Please enter license number');window.location.href='cashier_ExitScreen.php'</script>";
                }
            }
            if(isset($_POST['confirm'])) {
                header('location:cashier_HomeScreen.php');
                if($allow){
                    echo "hena";
                    $query4 = "SELECT * FROM garage WHERE garage_id = '$garageID';";
                    $queryRes=mysqli_query($conn,$query4);
                    $this_garage = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                    $availableSpots = $this_garage['ava_spots'];
                    $query5 = "DELETE FROM current_customers WHERE license_no='$license_No'";
                    $queryRes= mysqli_query($conn,$query5);
                    $query6 = "INSERT INTO reservation_confirmation (license_no, garage_id, entry_time, entry_cashier_id, exit_time, exit_cashier_id, total_fees) VALUES ($license_No, $garageID, $entryTime, $entryCashierID, $currentTimeStamp, $cashierID, $totalFees);";
                    $queryRes= mysqli_query($conn,$query6);
                    $query7 = "SELECT * FROM reservation_confirmation WHERE license_no = '$license_No';";
                    $queryRes= mysqli_query($conn,$query7);
                    $this_res = mysqli_fetch_array($queryRes,MYSQLI_ASSOC);
                    $reservation_no = $this_res['reservation_no'];
                    $new_availableSpots = $availableSpots + 1;
                    $query8 = "UPDATE `garage` SET `ava_spots` = '$new_availableSpots' WHERE `garage`.`garage_id` = $garageID";
                    $queryRes= mysqli_query($conn,$query8);
                    if(isset($_POST['polish'])){
                        $query9 = "INSERT INTO provided_services(reservation_no, service) VALUES($reservation_no, 'car_polish');";
                        $queryRes=mysqli_query($conn,$query9);
                    }
                    if(isset($_POST['interior'])){
                        $query9 = "INSERT INTO provided_services(reservation_no, service) VALUES($reservation_no, 'interior_wash');";
                        $queryRes=mysqli_query($conn,$query9);
                    }
                    if(isset($_POST['exterior'])){
                        $query9 = "INSERT INTO provided_services(reservation_no, service) VALUES($reservation_no, 'exterior_wash');";
                        $queryRes=mysqli_query($conn,$query9);
                    }
                    if(isset($_POST['tire'])){
                        $query9 = "INSERT INTO provided_services(reservation_no, service) VALUES($reservation_no, 'tire_gauge');";
                        $queryRes=mysqli_query($conn,$query9);
                    }
                }
            }

?>
<body style="background-image: url('mizoo5.jpg');height: 100%; width:100%; background-repeat: no_repeat; background-size: contain;">
    <form class="formStyle" method="post">
    <input class = "inputField" name="licenseNo" placeholder="   Enter customer license number" onfocus="if(this.placeholder=='   Enter customer license number') this.placeholder='';" onblur="if(this.placeholder=='') this.placeholder='   Enter customer license number';" value = <?php if(isset($_POST['submit'])) if($_POST['licenseNo']) echo htmlspecialchars($_POST['licenseNo'])?>></input><br>
    <div class="row">
        <div class="column">
            <div class="left_div">
                <label><b>Choose applied services:</b></label><br>
                <input type="checkbox" id="service1" name="polish" <?php if(isset($_POST['submit'])){ if(isset($_POST['polish'])){ echo "checked='checked'";}} ?>>
                <label for="service1"> Car Polish</label><br>
                <input type="checkbox" id="service2" name="interior" <?php if(isset($_POST['submit'])){ if(isset($_POST['interior'])){ echo "checked='checked'";}} ?>>
                <label for="service2"> Interior Wash</label><br>
                <input type="checkbox" id="service3" name="exterior" <?php if(isset($_POST['submit'])){ if(isset($_POST['exterior'])){ echo "checked='checked'";}} ?>>
                <label for="service3"> Exterior Wash</label><br>
                <input type="checkbox" id="service4" name="tire" <?php if(isset($_POST['submit'])){ if(isset($_POST['tire'])){ echo "checked='checked'";}}?>>
                <label for="service4"> Tire Gauge</label><br>
                <input type="submit" name="submit" value="Calculate" class="submit-btn1"></input>
            </div>
        </div>
        <div class="column">
            <div class="right_div">
                <div class="row21" style="margin-bottom: 10px">
                    <label>Total fees:</label><br>
                    <label style="margin-left: 350px;"><?php echo htmlspecialchars($totalFees)?> L.E</label><br>
                    <label style="margin-top: 50px;">To be paid/returned:</label><br>
                    <label style="margin-left: 320px;"><?php echo htmlspecialchars($feesToPay)?>/</label>
                    <label><?php echo htmlspecialchars($feestoReturn)?> L.E</label>
                </div>
            </div>
        </div>
    </div>
    </form>
    <form method="post">
        <input type="submit" name="confirm" value="confirm checkout" class="submit-btn2"></input>
    </form>
</body>
<style>
    .inputField{
        width: 550px;
        height: 80px;
        border-radius: 15px;
        background-color: #E8E8E8;
        margin-bottom: 32px;
        margin-top: 160px;
        margin-left: 150px;
        font-size: 18px;
        text-align: center;
    }
    .formStyle{
        font-size: 24px;
        color: white;
        margin-left: 0px;
    }
    .submit-btn2{
        padding: 10px 15px;
        background-color: #009925;
        border-radius: 3px;
        border: none;
        cursor: pointer;
        margin-left: 1050px;
        margin-top: 10px;
    }
    .submit-btn1{
        padding: 10px 15px;
        width: 120px;
        background-color: #b8cad0;
        border-radius: 3px;
        border: none;
        cursor: pointer;
        margin-top: 30px;
        margin-left: 430px;
    }
    .column {
        float: left;
        width: 50%;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .left_div{
        margin-left: 155px;
    }
    .right_div{
        margin-left: 0px;
        margin-top: 50px;
    }
</style>
</html>