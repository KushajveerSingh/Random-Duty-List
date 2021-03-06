<?php
    session_start();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        require 'server_init.php';

        if ($_POST['logout']) {
            $_SESSION['loggedin'] = false;
            header("Location:index.php");
            exit();
        }

        // Check whether the list is generated or not
        $sql = "SELECT COUNT(*) AS NumRows FROM AssignedA WHERE Date='$currentDate'";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_assoc($result)['NumRows'];
        if ($rows == 0) {
            echo "Please generate the list first</br>";
        }
        else {
            $sql1 = "SELECT * FROM AssignedA WHERE Date='$currentDate' ORDER BY StationName";
            $sql2 = "SELECT * FROM AssignedB WHERE Date='$currentDate' ORDER BY StationName";
            $sql3 = "SELECT * FROM AssignedC WHERE Date='$currentDate' ORDER BY StationName";
            $result1 = mysqli_query($conn, $sql1);
            $result2 = mysqli_query($conn, $sql2);
            $result3 = mysqli_query($conn, $sql3);
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name+"viewport" content="width=device-width">
        <meta name="description" content="Admin Login page for the project">
        <meta name="author" content="Kushajveer Singh">
        <title>Assigned People</title>
        <link rel="stylesheet" href="./CSS/style.css">
    </head>
    <body>
        <header>
            <center>
                <img src="./Images/main.png" alt="Chandigarh Police Logo" style="width:70px; height:90px; float:left; padding-left:25%">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="submit" name="logout" value="Logout" class="logoutButton">
                </form>
                <h1 style="color:red; font-size:45px">Chandigarh Police</h1>
            </center>
        </header>
    </body>
</html>
<?php
    echo "<center>";
    echo "<h2>For CategoryA</h2></br>";
    echo "<table border=1>";
    if (mysqli_num_rows($result1) > 0) {
        echo "<tr>";
        echo "<th align=center width=50px>ID</th>";
        echo "<th align=center width=150px>FirstName</th>";
        echo "<th align=center width=150px>LastName</th>";
        echo "<th align=center width=150px>Staion Name</th>";
        echo "<th align=center width=200px>Station Address</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_assoc($result1)) {
            echo "<tr>";
            echo "<td align=center>" . $row["ID"] . "</td>";
            echo "<td align=center>" . $row["FirstName"] . "</td>";
            echo "<td align=center>" . $row["LastName"] . "</td>";
            echo "<td align=center>" . $row["StationName"] . "</td>";
            echo "<td align=center>" . $row["StationAddress"] . "</td>";
            echo "</tr>";
        }
        echo "</table></br>";
    }
    else {
        echo "No one assigned</br>";
    }
    echo "</br>";

    echo "<h2>For CategoryB</h2></br>";
    echo "<table border=1>";
    if (mysqli_num_rows($result2) > 0) {
        echo "<tr>";
        echo "<th align=center width=50px>ID</th>";
        echo "<th align=center width=150px>FirstName</th>";
        echo "<th align=center width=150px>LastName</th>";
        echo "<th align=center width=150px>Staion Name</th>";
        echo "<th align=center width=200px>Station Address</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_assoc($result2)) {
            echo "<tr>";
            echo "<td align=center>" . $row["ID"] . "</td>";
            echo "<td align=center>" . $row["FirstName"] . "</td>";
            echo "<td align=center>" . $row["LastName"] . "</td>";
            echo "<td align=center>" . $row["StationName"] . "</td>";
            echo "<td align=center>" . $row["StationAddress"] . "</td>";
            echo "</tr>";
        }
        echo "</table></br>";
    }
    else {
        echo "No one assigned</br>";
    }
    echo "</br>";

    echo "<h2>For CategoryC</h2></br>";
    echo "<table border=1>";
    if (mysqli_num_rows($result3) > 0) {
        echo "<tr>";
        echo "<th align=center width=50px>ID</th>";
        echo "<th align=center width=150px>FirstName</th>";
        echo "<th align=center width=150px>LastName</th>";
        echo "<th align=center width=150px>Staion Name</th>";
        echo "<th align=center width=200px>Station Address</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_assoc($result3)) {
            echo "<tr>";
            echo "<td align=center>" . $row["ID"] . "</td>";
            echo "<td align=center>" . $row["FirstName"] . "</td>";
            echo "<td align=center>" . $row["LastName"] . "</td>";
            echo "<td align=center>" . $row["StationName"] . "</td>";
            echo "<td align=center>" . $row["StationAddress"] . "</td>";
            echo "</tr>";
        }
        echo "</table></br>";
    }
    else {
        echo "No one assigned</br>";
    }
    echo "</br>";
    echo "</center>";
    echo "<footer>";
            echo "<p>Punjab Engineering College, Sector-12, Chandigarh</p>";
    echo "</footer>";
    }
}
else {
    header("Location:index.php");
    exit();
}
?>
