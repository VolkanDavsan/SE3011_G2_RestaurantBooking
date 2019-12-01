<?php
include('session.php');
include("dbconnect.php");
$sql = "SELECT * FROM restaurant_owner ";

//cuisine filters
$cuisinearray = array();
if (isset($_POST['filterSubmit'])) {

    if (isset($_POST['filter'])) { // filter isimli checkboxlardan hiçbiri dolu değil mi diye kontrol ediyor 

        $sql .= 'WHERE cuisines LIKE '; 
        $cuisines = $_POST['filter'];
        foreach ($_POST['filter'] as $cuisines) {
            $cuisinearray[] = "'%" . $cuisines . "%'";
        }
        $states = implode(" OR cuisines LIKE ", $cuisinearray);
        $sql .= $states;
    }
}


//seating filters
$seatingarray = array();
if (isset($_POST['filterSubmit'])) {

    if (isset($_POST['filter1'])) { // filter1 isimli checkboxlardan hiçbiri dolu değil mi diye kontrol ediyor 

        if (!isset($_POST['filter'])) {  // filter isimli checkboxlardan hiçbiri dolu değil mi diye kontrol ediyor oan göre query düzenliyor. dolu değilse WHERE doluysa AND 
            $sql .= 'WHERE seating_option LIKE ';
        } else {
            $sql .= ' AND seating_option LIKE ';
        }

        $seating = $_POST['filter1'];
        foreach ($_POST['filter1'] as $seating) {
            $seatingarray[] = "'%" . $seating . "%'";
        }
        $states1 = implode(" OR seating_option LIKE ", $seatingarray);
        $sql .= $states1;
    }
}

//price filters
$pricearray = array();
if (isset($_POST['filterSubmit'])) {

    if (isset($_POST['filter2'])) { // filter2 isimli checkboxlardan hiçbiri dolu değil mi diye kontrol ediyor 

        if (!isset($_POST['filter']) && !isset($_POST['filter1'])) {  // filter, filter1 isimli checkboxlardan hiçbiri dolu değil mi diye kontrol ediyor oan göre query düzenliyor. dolu değilse WHERE doluysa AND
            $sql .= 'WHERE price = ';
        } else {
            $sql .= ' AND price = ';
        }

        $price = $_POST['filter2'];
        foreach ($_POST['filter2'] as $price) {
            $pricearray[] = "'" . $price . "'";
        }
        $states2 = implode(" OR seating_option LIKE ", $pricearray);
        $sql .= $states2;
    }
}


//stars filter
$starsarray = array();
if (isset($_POST['filterSubmit'])) {

    if (isset($_POST['filter3'])) { // filter3 isimli checkboxlardan hiçbiri dolu değil mi diye kontrol ediyor 

        if (!isset($_POST['filter']) && !isset($_POST['filter1'])&& !isset($_POST['filter2'])) { // filter, filter1 ve filter2 isimli checkboxlardan hiçbiri dolu değil mi diye kontrol ediyor oan göre query düzenliyor. dolu değilse WHERE doluysa AND
            $sql .= 'WHERE stars = ';
        } else {
            $sql .= ' AND stars = ';
        }

        $stars = $_POST['filter3'];
        foreach ($_POST['filter3'] as $stars) {
            $starsarray[] = "'" . $stars . "'";
        }
        $states3 = implode(" OR seating_option LIKE ", $starsarray);
        $sql .= $states3;
    }
}


$result = mysqli_query($conn, $sql);
//post methodunadan çekiyor query ye koyuyo implode bir arrayın her elemanı arasına OR cuisines LIKE koyuyor
?>

<html>

    <link rel="stylesheet" type="text/css" href="style.css"></link>
    <script src="scripts.js"></script>
    <body>
        <?php echo $sql ?> <!-- to see the written query in the first php block !-->
    <div class="container" id="fullC">

        <div class="top">
            <button onclick="openForm2()"  id="rsignup">Restaurant Sign Up</button>
            <button onclick="openForm3()"  id="signup" >Sign Up</button>
            <button onclick="openForm()"   id="signin" >Sign In</button>         
            <a href="returnHP.php"><img src="img/LOGO.png" alt="RBS" style="width:150px"></a>
        </div> 

        <div class="filters"> 
            <form action="filterSearchGuest.php" method="post">
                <div class="cuisineOptions">
                    <table>
                        <tr><p>Cuisines</p></tr>
                        <tr><input type="checkbox" id="selectAll" onclick="checkAll('chk')" name="filter" value="All">All</input><br></tr>
                        <tr><input type="checkbox" id="chk" name="filter[]" value="Mediterranean Food">Mediterranean Food</input><br></tr>
                        <tr><input type="checkbox" id="chk" name="filter[]" value="Turkish Food">Turkish Food</input><br>  </tr>
                        <tr><input type="checkbox" id="chk" name="filter[]" value="French Food">French Food</input><br></tr>
                        <tr><input type="checkbox" id="chk" name="filter[]" value="International">International</input><br></tr>
                        <tr><input type="checkbox" id="chk" name="filter[]" value="Grid&Steak">Grid&Steak</input><br></tr>
                        <tr><input type="checkbox" id="chk" name="filter[]" value="Fish">Fish</input><br></tr>
                        <tr><input type="checkbox" id="chk" name="filter[]" value="Aegean Food">Aegean Food</input><br></tr>
                        <tr><input type="checkbox" id="chk" name="filter[]" value="Black Sea Food" >Black Sea Food</input><br>  </tr>
                        <tr><input type="checkbox" id="chk" name="filter[]" value="Middle East Food" >Middle East Food</input><br> 
                    </table>
                </div>
                <div class="seatingOptions">
                    <table>
                        <tr><p>Seating Options</p></tr>
                        <tr><input type="checkbox" id="selectAll" onclick="checkAll('chk1')" name="filter1" value="All">All</input><br></tr>
                        <tr><input type="checkbox" id="chk1" name="filter1[]" value="Bar">Bar</input><br></tr>
                        <tr><input type="checkbox" id="chk1" name="filter1[]" value="High Top">High Top</input><br>  </tr>
                        <tr><input type="checkbox" id="chk1" name="filter1[]" value="Standart">Standart</input><br></tr>
                        <tr><input type="checkbox" id="chk1" name="filter1[]" value="Outdoor">Outdoor</input><br></tr>
                    </table>
                </div>
                <div class="priceOptions">
                    <table>
                        <tr><p>Price Options</p></tr>
                        <tr><input type="checkbox" id="selectAll" onclick="checkAll('chk2')" name="filter2" value="All">All</input><br></tr>
                        <tr><input type="checkbox" id="chk2" name="filter2[]" value="$">$</input><br></tr>
                        <tr><input type="checkbox" id="chk2" name="filter2[]" value="$$">$$</input><br>  </tr>
                        <tr><input type="checkbox" id="chk2" name="filter2[]" value="$$$">$$$</input><br></tr>
                    </table>
                </div>
                <div class="rankOptions">
                    <table>
                        <tr><p>Rank Options</p></tr>
                        <tr><input type="checkbox" id="selectAll" onclick="checkAll('chk3')" name="filter3" value="All">All</input><br></tr>
                        <tr><input type="checkbox" id="chk3" name="filter3[]" value="5">5</input><br></tr>
                        <tr><input type="checkbox" id="chk3" name="filter3[]" value="4">4</input><br></tr>
                        <tr><input type="checkbox" id="chk3" name="filter3[]" value="3">3</input><br></tr>
                        <tr><input type="checkbox" id="chk3" name="filter3[]" value="2">2</input><br></tr>
                        <tr><input type="checkbox" id="chk3" name="filter3[]" value="1">1</input><br></tr>
                    </table>
                </div>
                <input type="submit" name="filterSubmit" value="Submit"></input>
            </form>
        </div>
        <div class="results">
            <table id="searchResults">
                <?php
                echo "<tr><th style=width:30%;> Restaurant Name </th><th style=width:40%;> Adress </th><th style=width:20%;> Phone Number </th><th style=width:10%;>  </th></tr> <br>";

                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                    echo "<tr> "
                    . "<td> " . $row["rest_name"] . " </td>"
                    . "<td> " . $row["address"] . " </td>"
                    . "<td> " . $row["phoneNo"] . " </td>
                       <td> <button onclick='openForm()'>Sign In</button></td>
                       </tr> <br>";
                }
                echo "</table>";
                ?>
            </table>
        </div>

    </body>
    <div class="form-popup" id="signIn">
        <form method="post" class="form-container" action="signIn.php">
            <h3>Sign In</h3>
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="  Enter Username" name="username" required/>
            <br><br>
            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="  Enter Password" name="psw" required/>
            <span class="forgotpsw"> <a href="#" onclick="openForm4()">Forgot password?</a></span>
            <br><br>
            <button type="submit" class="btn">Login</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
        </form>
    </div>
</html>
