<!DOCTYPE html>
<link rel="stylesheet" href="style.css"></link>
<script src="scripts.js"></script>
<?php include('bootstrapinclude.php') ?>
<?php
session_start();
include("dbconnect.php");

if (!isset($_SESSION['username'])) {
    header('location:signIn.php');
} else {
    $viewerUsername = $_SESSION['username'];
    $sql_rest = "SELECT * FROM restaurant_owner WHERE uname='$viewerUsername'";
    $query_rest = mysqli_query($conn, $sql_rest);
    $sql_ad = "SELECT * FROM admin WHERE uname='$viewerUsername'";
    $query_ad = mysqli_query($conn, $sql_ad);
    if (mysqli_num_rows($query_rest) > 0 || mysqli_num_rows($query_ad) > 0) {
        header('location:index.php');
    }
}

//INITIALIZING OF VARIABLES
$c_username = "";
$r_username = "";
$date = "";
$startTime = "";
$endTime = "";
$phone = "";
$fname = "";
$lname = "";
$email = "";
$party = "";

$feedbacks = array();
$errors = array();

//PULL THE DATAS OF THE BOOKING
$bookId = $_GET['varname'];
$sqlBook = "select * from bookings where bookingId = '$bookId'";
$queryBook = mysqli_query($conn, $sqlBook);
$bookArray = mysqli_fetch_assoc($queryBook);
$restUname = $bookArray['restaurant_uname'];
$sqlRest = "select * from restaurant_owner where uname = '$restUname'";
$queryRest = mysqli_query($conn, $sqlRest);
$restArray = mysqli_fetch_assoc($queryRest);
$start = $restArray['startTime'];
$end = $restArray['endTime'];
$cap = $restArray['cap'];

$count = mysqli_num_rows($queryBook);
if ($count == 0) {
    header('location:errorPage.php');
}

// IF THE EDIT BOOKING BUTTON ACTIVATED PULL THE INPUTS FROM THE FORM
if (isset($_POST['editBooking'])) {
    $c_username = $_SESSION['username'];
    $r_username = $restUname;
    $date = filter_input(INPUT_POST, 'date');
    $startTime = filter_input(INPUT_POST, 'startTime');
    $endTime = filter_input(INPUT_POST, 'endTime');
    $phone = filter_input(INPUT_POST, 'phoneNo');
    $fname = filter_input(INPUT_POST, 'fname');
    $lname = filter_input(INPUT_POST, 'lname');
    $email = filter_input(INPUT_POST, 'email');
    $party = filter_input(INPUT_POST, 'party');

    //CHECK THE VALIDITY OF THE FORM
    if (empty($fname)) {
        array_push($errors, "First Name is required");
    }
    if (empty($lname)) {
        array_push($errors, "Last Name is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($startTime)) {
        array_push($errors, "Start time is required");
    }
    if (empty($endTime)) {
        array_push($errors, "End time is required");
    }
    if (empty($party)) {
        array_push($errors, "Party size is required");
    }
    if (empty($phone)) {
        array_push($errors, "Phone number is required");
    }
    if (empty($date)) {
        array_push($errors, "Booking date is required");
    }
    if ($startTime > $endTime) {
        array_push($errors, "Starting time of the booking cannot be later than ending time.");
    }

    //FIND THE RESTAURANT
    $query1 = mysqli_query($conn, "SELECT * FROM bookings WHERE restaurant_uname = '$r_username' AND date = '$date'");
    $partySize = 0;
    $i = 0;
    //CALCULATE THE AVAILABLE CAPACITY OF THE RESTAURANT DURING THE RESERVATION 
    while ($array = mysqli_fetch_array($query1, MYSQLI_ASSOC)) {
        if (!(strtotime($startTime) - strtotime($array['end_time']) >= 0 || strtotime($array['start_time']) - strtotime($endTime) >= 0)) {
            if ($array['bookingId'] != $bookId) {
                $partySize = $partySize + $array['party'];
            }
        }
    }
    $currentCap = $cap - $partySize;

    //CHECK IF THE PARTY SIZE FITS IN AVAILABLE CAPACITY AND MAKE THE RESERVATION
    if ($currentCap >= $party && count($errors) == 0) {
        $queryDelete = mysqli_query($conn, "delete from bookings where bookingId = '$bookId'");
        $queryInsert = mysqli_query($conn, "insert into bookings(customer_uname,restaurant_uname,party,start_time,end_time,fname,lname,email,phoneNo,date,is_suspended) VALUES('$c_username', '$r_username','$party','$startTime','$endTime','$fname','$lname','$email','$phone','$date',0)");
        $notification1SQL = "insert into notification(toName,text,link,isRead) values('$r_username','A Booking for your restaurant has been editted. Click to go to Restaurant Panel' ,'RestaurantOwner.php' ,0)";
        $notification2SQL = "insert into notification(toName,text,link,isRead) values('$c_username','You editted one of your bookings. Click to view Your Bookings' ,'viewMyBookings.php?varname=$c_username' ,0)";
        $queryNoti1 = mysqli_query($conn, $notification1SQL);
        $queryNoti2 = mysqli_query($conn, $notification2SQL);
        array_push($feedbacks, "Your booking has been editted.");
        array_push($feedbacks, "You will be redirected to Your Bookings when you click 'OK' button.");
    } else if (!($currentCap >= $party)) {
        array_push($errors, "There are no capacity in the restaurant that meets your party size at the selected hours.");
    } 
}
?>
