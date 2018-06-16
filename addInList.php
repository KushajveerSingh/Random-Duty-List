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
            if ($buttonPressed == "Add") {
                $id = $_POST['id'];
                $category = $_POST['category'];
                $station = $_POST['station'];
                $currentDate = date("Y/m/d");
                if ($category == "CategoryA") {
                    $randomTable = "RandomListA";
                    $assignTable = "AssignedA";
                }
                elseif ($category == "CategoryB") {
                    $randomTable = "RandomListB";
                    $assignTable = "AssignedB";
                }
                elseif ($category == "CategoryC") {
                    $randomTable = "RandomListC";
                    $assignTable = "AssignedC";
                }

                // Check if the person is present in the main list, if not show a message
                $sql = "SELECT COUNT(ID) AS Count FROM $category WHERE ID='$id'";
                $result = mysqli_query($conn, $sql);
                $rows = mysqli_fetch_assoc($result)['Count'];
                if ($rows == 0) {
                    echo '<script language="javascript">';
                    echo 'alert("Person not yet added to the main list")';
                    echo '</script>';
                }
                else {
                    $sql = "SELECT COUNT(ID) AS Count FROM $assignTable WHERE ID='$id' AND Date='$currentDate'";
                    $result = mysqli_query($conn, $sql);
                    $rows = mysqli_fetch_assoc($result)['Count'];
                    if ($rows == 1) {
                        $sql = "SELECT StationName FROM $assignTable WHERE ID='$id'";
                        $result = mysqli_query($conn, $sql);
                        $rows = mysqli_fetch_assoc($result)["StationName"];
                        echo "Person is already assigned to station:- " . $rows . "</br>";
                    }
                    else {
                        $sql = "UPDATE $randomTable SET Free=0 WHERE ID='$id'";
                        if (!mysqli_query($conn, $sql)) {
                            echo "Error updating RandomTable: " . mysqli_error($conn);
                        }

                        $sql = "SELECT Address FROM Stations WHERE Name='$station'";
                        $result = mysqli_query($conn, $sql);
                        $stationAddress = mysqli_fetch_assoc($result)["Address"];

                        $sql = "INSERT INTO $assignTable (ID, FirstName, LastName, Date, StationName, StationAddress) SELECT ID, FirstName, LastName, '$currentDate', '$station', '$stationAddress' FROM $category WHERE ID='$id'";
                        if (!mysqli_query($conn, $sql)) {
                            echo "Error updating AssignTable: " . mysqli_error($conn);
                        }

                        echo '<script language="javascript">';
                        echo 'alert("Person Assigned")';
                        echo '</script>';
                    }
                }
            }
            elseif ($buttonPressed == "Cancel") {
                header("Location:editList.php");
                exit();
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
        <title>Add To List</title>
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
                <h2>Add Person to List</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="cancel">
                    <table>
                        <tr>
                            <td><label for="selectCategory">Category:</label></td>
                            <td>
                                <select class="selectBox" name="category">
                                    <option value="CategoryA">CategoryA</option>
                                    <option value="CategoryB">CategoryB</option>
                                    <option value="CategoryC">CategoryC</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Station:</td>
                            <td>
                                <?php
                                    $sql = "SELECT Name FROM Stations";
                                    $result =mysqli_query($conn, $sql);
                                    echo "<select class='selectBox' name='station'>";
                                    while ($rows = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $rows["Name"] . "'>" . $rows["Name"] . "</option>";
                                    }
                                    echo "</select>";
                                    ?>
                            </td>
                        </tr>
                        <tr>
                            <td>ID:</td>
                            <td><input type="number" name="id" placeholder="Enter ID of person" required class="enterText"></td>
                        </tr>
                    </table>
                    <input type="submit" name="button" value="Add" class="formEnd">
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
