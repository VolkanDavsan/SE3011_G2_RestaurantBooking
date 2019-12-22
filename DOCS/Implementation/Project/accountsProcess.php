<?php
include('dbconnect.php');
session_start();
$errors = array();
$feedbacks = array();
if (!isset($_SESSION['success'])) {
    header('location:index.php');
}

$uname = $_GET['varname'];

$current_email = "";
$email_1 = "";
$email_2 = "";

if (isset($_POST['changePassword'])) {
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
    if (empty($current_password)) {
        array_push($errors, "Current Password is required");
    }if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if (empty($password_2)) {
        array_push($errors, "Re-Password is required");
    }

    if (count($errors) == 0) {

        $query1 = "SELECT * FROM user WHERE uname='$uname'";
        $query2 = "SELECT * FROM restaurant_owner WHERE uname='$uname'";
        $query3 = "SELECT * FROM admin WHERE uname='$uname'";
        $results1 = mysqli_query($conn, $query1);
        $results2 = mysqli_query($conn, $query2);
        $results3 = mysqli_query($conn, $query3);
        $array = array();
        if ($results1) {
            $array = mysqli_fetch_assoc($results1);
        } else if ($results2) {
            $array = mysqli_fetch_assoc($results2);
        } else if ($results3) {
            $array = mysqli_fetch_assoc($results3);
        }

        md5($current_password);
        if ($current_password != $array['psw']) {

            if ($password_1 != $password_2) {
                array_push($errors, "Password do not match.");
            } else {

                $password = md5($password_1);
                if (mysqli_num_rows($results1) == 1) {
                    $changeP = mysqli_query($conn, "UPDATE user SET psw = '$password'  WHERE (uname = '$uname')");
                    array_push($feedbacks, "Your password has been changed.");
                    array_push($feedbacks, "You will be redirected to the Sign In screen when you click 'OK' button.");
                } else if (mysqli_num_rows($results2) == 1) {
                    $changeP = mysqli_query($conn, "UPDATE restaurant_owner SET psw = '$password'  WHERE (uname = '$uname')");
                    array_push($feedbacks, "Your password has been changed.");
                    array_push($feedbacks, "You will be redirected to the Sign In screen when you click 'OK' button.");
                } else if (mysqli_num_rows($results3) == 1) {
                    $changeP = mysqli_query($conn, "UPDATE admin SET psw = '$password'  WHERE (uname = '$uname')");
                    array_push($feedbacks, "Your password has been changed.");
                    array_push($feedbacks, "You will be redirected to the Sign In screen when you click 'OK' button.");
                } else {
                    array_push($feedbacks, "Your password has been changed.");
                    array_push($feedbacks, "You will be redirected to the Sign In screen when you click 'OK' button.");
                }
            }
        } else {
            arrays_push($errors, "Your current password is wrong.");
        }
    }
}


if (isset($_POST['changeEmail'])) {
    $current_email = mysqli_real_escape_string($conn, $_POST['current_email']);
    $email_1 = mysqli_real_escape_string($conn, $_POST['email_1']);
    $email_2 = mysqli_real_escape_string($conn, $_POST['email_2']);
    if (empty($current_email)) {
        array_push($errors, "Current Email is required");
    }if (empty($email_1)) {
        array_push($errors, "Email is required");
    }
    if (empty($email_2)) {
        array_push($errors, "Re-Email is required");
    }

    if (count($errors) == 0) {

        $query1 = "SELECT * FROM user WHERE uname='$uname'";
        $query2 = "SELECT * FROM restaurant_owner WHERE uname='$uname'";
        $query3 = "SELECT * FROM admin WHERE uname='$uname'";
        $results1 = mysqli_query($conn, $query1);
        $results2 = mysqli_query($conn, $query2);
        $results3 = mysqli_query($conn, $query3);
        if ($result1) {
            $array = mysqli_fetch_assoc($results1);
        } else if ($resut2) {
            $array = mysqli_fetch_assoc($results2);
        } else if ($result3) {
            $array = mysqli_fetch_assoc($results3);
        }
        
        if ($current_email != $array['email']) {

            if ($email_1 != $email_2) {
                array_push($errors, "Emails do not match.");
            } else {

                if (mysqli_num_rows($results1) == 1) {
                    $changeP = mysqli_query($conn, "UPDATE user SET email = '$email_1'  WHERE (uname = '$uname')");
                    array_push($feedbacks, "Your email has been changed.");
                    array_push($feedbacks, "You will be redirected to the Sign In screen when you click 'OK' button.");
                } else if (mysqli_num_rows($results2) == 1) {
                    $changeP = mysqli_query($conn, "UPDATE restaurant_owner SET email = '$email_1'  WHERE (uname = '$uname')");
                    array_push($feedbacks, "Your email has been changed.");
                    array_push($feedbacks, "You will be redirected to the Sign In screen when you click 'OK' button.");
                } else if (mysqli_num_rows($results3) == 1) {
                    $changeP = mysqli_query($conn, "UPDATE admin SET email = '$email_1'  WHERE (uname = '$uname')");
                    array_push($feedbacks, "Your email has been changed.");
                    array_push($feedbacks, "You will be redirected to the Sign In screen when you click 'OK' button.");
                } else {
                    array_push($feedbacks, "Your email has not been changed.");
                    array_push($feedbacks, "You will be redirected to the home page screen when you click 'OK' button.");
                }
                header('location: index.php');
            }
        } else {
            arrays_push($errors, "Your current email is wrong.");
        }
    }
}

?>
