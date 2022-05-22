<?php
$host="localhost";
$user="root";
$password="";
$db="parkinggaragesystem";

$con=mysqli_connect($host,$user,$password);
mysqli_select_db($con,$db);

/*Search Part for Cashiers*/
if($_POST['search'] == 'cashiers-search'){
    $sql1="SELECT * FROM cashier cr";
    echo $sql1;
    $result=mysqli_query($con,$sql1);
    if (mysqli_num_rows($result) > 0) {
        echo "<table border=\"2\"><tr><th>Cashier ID</th><th>First Name</th><th>Last Name</th>
        <th>Username</th><th>Garage ID</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
        echo "<tr class='clickable' onclick=\"window.location='manager.html'\">
        <td>".$row["cashier_id"]."</td>
        <td>".$row["first_name"]."</td><td>".$row["last_name"]."</td>
        <td>".$row["username"]."</td><td>".$row["garageID"]."</td>
        </tr>";
        }
        echo "</table><br>";
    } else {
        echo "0 results";
    }
}

/*Search Part for Customers*/
if($_POST['search'] == 'customers-search'){
    $sql1="SELECT * FROM customer cr ";
    echo $sql1;
    $result=mysqli_query($con,$sql1);
    if (mysqli_num_rows($result) > 0) {
        echo "<table border=\"2\"><tr><th>Customer ID</th><th>First Name</th><th>Last Name</th>
        <th>Username</th><th>License Num</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
        echo "<tr class='clickable' onclick=\"window.location='manager.html'\">
        <td>".$row["cust_id"]."</td>
        <td>".$row["first_name"]."</td><td>".$row["last_name"]."</td>
        <td>".$row["username"]."</td><td>".$row["license_no"]."</td>
        </tr>";
        }
        echo "</table><br>";
    } else {
        echo "0 results";
    }
}

/*Search Part for Customer Reservations*/
if($_POST['search'] == 'reservations-search'){
    $sql1="SELECT * FROM customer_reservation cr ";
    echo $sql1;
    $result=mysqli_query($con,$sql1);
    if (mysqli_num_rows($result) > 0) {
        echo "<table border=\"2\"><tr><th>Reservation Num</th><th>Customer ID</th><th>Garage ID</th><th>Entry Time</th>
        <th>Exp Exit Time</th><th>Total Fees</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
        echo "<tr class='clickable' onclick=\"window.location='manager.html'\">
        <td>".$row["reservation_no"]."</td><td>".$row["cust_id"]."</td><td>".$row["garage_id"]."</td>
        <td>".$row["entry_time"]."</td><td>".$row["exp_exit_time"]."</td>
        <td>".$row["total_fees"]."</td>
        </tr>";
        }
        echo "</table><br>";
    } else {
        echo "0 results";
    }
}
/*Search Part for Current Customers*/
if($_POST['search'] == 'currentCustomers-search'){
    $sql1="SELECT * FROM current_customers cc ";
    echo $sql1;
    $result=mysqli_query($con,$sql1);
    if (mysqli_num_rows($result) > 0) {
        echo "<table border=\"2\"><tr><th>Reservation Num</th><th>Entry Time</th><th>Entry Cashier ID</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
        echo "<tr class='clickable' onclick=\"window.location='manager.html'\">
        <td>".$row["reservation_no"]."</td><td>".$row["entry_id"]."</td><td>".$row["entry_cashier_id"]."</td>
        </tr>";
        }
        echo "</table><br>";
    } else {
        echo "0 results";
    }
}

/*Search Part for Garages*/
if($_POST['search'] == 'garages-search'){
    $sql1="SELECT * FROM garage g ";
    echo $sql1;
    $result=mysqli_query($con,$sql1);
    if (mysqli_num_rows($result) > 0) {
        echo "<table border=\"2\"><tr><th>Garage ID</th><th>Garage Name</th><th>Available Spots</th>
        <th>Total Spots</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
        echo "<tr class='clickable' onclick=\"window.location='manager.html'\">
        <td>".$row["garage_id"]."</td><td>".$row["garage_name"]."</td>
        <td>".$row["ava_spots"]."</td><td>".$row["total_spots"]."</td>
        </tr>";
        }
        echo "</table><br>";
    } else {
        echo "0 results";
    }
}
/*Search Part for Confirmed Reservations*/
if($_POST['search'] == 'confirmedReserve-search'){
    $sql1="SELECT * FROM reservation_confirmation rc ";
    echo $sql1;
    $result=mysqli_query($con,$sql1);
    if (mysqli_num_rows($result) > 0) {
        echo "<table border=\"1\"><tr><th>Reservation Num</th><th>Exit Cashier ID</th><th>Entry Cashier ID</th><th>Entry Time</th>
        <th>Exit Time</th><th>Total Fees</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
        echo "<tr class='clickable' onclick=\"window.location='manager.html'\">
        <td>".$row["reservation_no"]."</td><td>".$row["exit_cashier_id"]."</td><td>".$row["entry_cashier_id"]."</td>
        <td>".$row["entry_time"]."</td><td>".$row["exit_time"]."</td>
        <td>".$row["total_fees"]."</td>
        </tr>";
        }
        echo "</table><br>";
    } else {
        echo "0 results";
    }
}
?>