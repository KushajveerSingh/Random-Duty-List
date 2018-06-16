<?php
    session_start();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        require 'server_init.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST['logout']) {
                $_SESSION['loggedin'] = false;
                header("Location:index.php");
                exit();
            }

            $buttonPressed = $_POST['button'];
            $name = $_POST['name'];
            $address = $_POST['address'];

            if ($buttonPressed == "Cancel") {
                header("Location:main_page.php");
                exit();
            }

            if ($buttonPressed == 'Add') {
                $sql = "INSERT INTO Stations VALUES ('$name', '$address')";
                if (mysqli_query($conn, $sql)) {
                    echo '<script language="javascript">';
                    echo 'alert("Station Added To Records")';
                    echo '</script>';
                }
                else {
                    echo "Error Inserting Station: " . mysqli_error($conn);
                }
            }
            elseif ($buttonPressed == 'Remove') {
                // Check if there is a sation to remove or not
                $sql = "SELECT COUNT(Name) AS Count FROM Stations WHERE Name='$name'";
                $result = mysqli_query($conn, $sql);
                $rows = mysqli_fetch_assoc($result)['Count'];

                if ($rows == 0) {
                    echo "No one to remove</br>";
                }
                else {
                    $sql = "DELETE FROM Stations WHERE Name='$name'";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script language="javascript">';
                        echo 'alert("Station Deleted From Records")';
                        echo '</script>';
                    }
                    else {
                        echo "Error Deleting Station: " . mysqli_error($conn);
                    }
                }
            }
        }
        ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
        <meta name+"viewport" content="width=device-width">
        <meta name="description" content="Admin Login page for the project">
        <meta name="author" content="Kushajveer Singh">
        <title>Station Add/Remove</title>
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

        <div class="container">
            <center>
                <h2>Add/Remove Station</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="cancel">
                    <table>
                        <tr>
                            <td>Station Name:</td>
                            <td><input type="text" name="name" placeholder="Enter Name" required class="enterText"></td>
                        </tr>
                        <tr>
                            <td>Station Address:</td>
                            <td><input type="text" name="address" placeholder="Enter Address" class="enterText"></td>
                        </tr>
                    </table>
                    <input type="submit" name="button" value="Add" class="formEnd">
                    <input type="submit" name="button" value="Remove" class="formEnd">
                </form>
                <form action="" method="post" class="cancel">
                    <input type="submit" name="button" value="Cancel" class="formEnd">
                </form>
            </center>
        </div>

        <footer>
            <p>Punjab Engineering College, Sector-12, Chandigarh</p>
        </footer>
    </body>
</html>
<?php
    }
    else {
        header("Location:index.php");
        exit();
    }
     ?>
