<!DOCTYPE html>
<link href="style.css" rel="stylesheet" ></link>
<script src="scripts.js" type="text/javascript"></script>
<?php
session_start();
include("dbconnect.php");
if (!isset($_SESSION['success'])) {
    header('location: index.php');
} else {
    $username = $_SESSION['username'];
    $query = mysqli_query($conn, "select * from admin where uname = '$username'");
    $counta = mysqli_num_rows($query);
    if ($counta != 1) {
        header("location:index.php");
    }
}
?>

<html>
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMIN PANEL</title>


</head>
<body>

<div class=container>
    <div class="top">
        <a href="SignOut.php"><button  id="signout">Sign Out </button></a>
        <button id="profile" ><?php echo $_SESSION['username'] ?></button>
        <a href="Admin.php"><img src="img/LOGO.png" alt="RBS" style="width:150px"></a>
    </div>
    <div class="wholepanel">


        <div class="adminpanel">

            <ul>
                <h1> Admin Panel </h1>
                <li><a onclick="openViewTickets()">View Request Tickets</a></li>
                <li><a href="#news">View Restaurant Signups</a></li>
                <li><a href="#contact">Ban User</a></li>
                <li><a href="#about">Warn User</a></li>
                <li><a onclick="openAdminSearch()">Search</a></li>
            </ul>
        </div>
        <div class="functions">

            <div class="adminsearchpart" id="adminsearch">
                <input type="text" id="adminsearchinput" onkeyup="searchFilterFunction()" placeholder="Search for usernames.." title="Type in a username"/>
                <div class="old_ie_wrapper">
                    <table id="adminSearchTable">
                        <thead>
                            <tr class="head">
                                <th style="width:60%;">Username</th>
                                <th style="width:40%;">Acc_Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "select uname from restaurant_owner ");
                            $query2 = mysqli_query($conn, "select uname from user ");
                            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                                $rest_uname = $row['uname'];
                                echo "<tr> <td><a href='restaurantProfile.php?varname=$rest_uname'> " . $row["uname"] . "</a></td>"
                                . "<td> " . "Restaurant Owner" . " </td> </tr>";
                            }
                            while ($row2 = mysqli_fetch_array($query2, MYSQLI_ASSOC)) {
                                echo "<tr> <td> " . $row2["uname"] . " </td>"
                                . "<td> " . "User" . " </td> </tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>


            <div class="adminsearchpart" id="viewTickets">
                <div class="old_ie_wrapper">
                    <table id="viewTicketsTable">
                        <thead>
                            <tr class="head">
                                <th style="width:40%;">Username</th>
                                <th style="width:30%">Category</th>
                                <th style="width:15%">Date</th>
                                <th style="width:15%">Is Responded</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "select user_uname,category,date,isResponded from ticket where isResponded=0 AND user_uname is not null ");
                            $query2 = mysqli_query($conn, "select rest_uname,category,date,isResponded from ticket where isResponded=0 AND rest_uname is not null");
                            $query3 = mysqli_query($conn, "select user_uname,category,date,isResponded from ticket where isResponded=1 AND user_uname is not null");
                            $query4 = mysqli_query($conn, "select rest_uname,category,date,isResponded from ticket where isResponded=1 AND rest_uname is not null");

                            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {

                                echo "<tr> <td>" . $row['user_uname'] . "</td>"
                                . "<td> " . $row['category'] . " </td> "
                                . "<td>" . $row['date'] . "</td>"
                                . "<td>" . "No" . "</td> </tr>";
                            }
                            while ($row2 = mysqli_fetch_array($query2, MYSQLI_ASSOC)) {

                                echo "<tr> <td>" . $row2['rest_uname'] . "</td>"
                                . "<td> " . $row2['category'] . " </td> "
                                . "<td>" . $row2['date'] . "</td>"
                                . "<td>" . "No" . "</td> </tr>";
                            }
                            while ($row2 = mysqli_fetch_array($query3, MYSQLI_ASSOC)) {

                                echo "<tr> <td>" . $row2['rest_uname'] . "</td>"
                                . "<td> " . $row2['category'] . " </td> "
                                . "<td>" . $row2['date'] . "</td>"
                                . "<td>" . "Yes" . "</td> </tr>";
                            }
                            while ($row2 = mysqli_fetch_array($query4, MYSQLI_ASSOC)) {

                                echo "<tr> <td>" . $row2['rest_uname'] . "</td>"
                                . "<td> " . $row2['category'] . " </td> "
                                . "<td>" . $row2['date'] . "</td>"
                                . "<td>" . "Yes" . "</td> </tr>";
                            }

                            ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

