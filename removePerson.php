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
            if ($buttonPressed == 'Remove') {
                $category = $_POST['category'];
                $id = $_POST['id'];

                // Check the person exists before removing
                $sql = "SELECT COUNT(ID) AS Count FROM $category WHERE ID='$id'";
                $result = mysqli_query($conn, $sql);
                $rows = mysqli_fetch_assoc($result)['Count'];
                if ($rows == 0) {
                    echo '<script language="javascript">';
                    echo 'alert("No Person To Remove")';
                    echo '</script>';
                }
                else {
                    $sql = "DELETE FROM $category WHERE ID=$id";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script language="javascript">';
                        echo 'alert("Person Removed")';
                        echo '</script>';
                    }
                    else {
                        echo "Error Removing Record: " . mysqli_error($conn);
                    }
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
        <title>Remove Person</title>
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
                <h2>Remove Person</h2>
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
                    </table>
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
