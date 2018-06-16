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
            if ($buttonPressed == 'Add') {
                $category = $_POST['category'];
                $id = $_POST['id'];
                $fName = $_POST['firstName'];
                $lName = $_POST['lastName'];
                // Get names of the random table to use
                if ($category == "CategoryA") {
                    $randomTable = "RandomListA";
                }
                elseif ($category == "CategoryB") {
                    $randomTable = "RandomListB";
                }
                else {
                    $randomTable = "RandomListC";
                }

                // First Insert Into category table. If you try to insert same person you get
                // Primary Key violation error. Also, add the person to the random teble with
                // free = 1
                $sql1 = "INSERT INTO $category VALUES ('$id', '$fName', '$lName')";
                $sql2 = "INSERT INTO $randomTable VALUES ('$id', 1)";
                if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
                    echo '<script language="javascript">';
                    echo 'alert("Person Added")';
                    echo '</script>';
                }
                else {
                    echo "Error Inserting Record: " . mysqli_error($conn);
                }
            }
            elseif ($buttonPressed == 'Cancel') {
                header("Location:main_page.php");
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
        <title>Add Person</title>
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
                <h2>Add Person</h2>
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
                            <td>ID:</td>
                            <td><input type="number" name="id" placeholder="Enter ID of person" required class="enterText"></td>
                        </tr>
                        <tr>
                            <td>First Name:</td>
                            <td><input type="text" name="firstName" placeholder="Enter First Name" required class="enterText"></td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td><input type="text" name="lastName" placeholder="Enter Last Name" class="enterText"></td>
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
