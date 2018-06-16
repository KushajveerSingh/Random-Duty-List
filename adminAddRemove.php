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
            $id = $_POST['id'];
            $name = $_POST['name'];
            $pass = $_POST['password'];
            $repass = $_POST['repassword'];

            if ($buttonPressed == "Cancel") {
                header("Location:main_page.php");
            }

            if ($pass == $repass) {
                if ($buttonPressed == 'Add') {
                    $sql = "INSERT INTO Admins VALUES ('$id', '$name', '$pass')";
                    if (mysqli_query($conn, $sql)) {
                        echo '<script language="javascript">';
                        echo 'alert("Admin Added To Records")';
                        echo '</script>';
                    }
                    else {
                        echo "Error Inserting Admin: " . mysqli_error($conn);
                    }
                }
                elseif ($buttonPressed == 'Remove') {
                    // Check if there is someone to remove from the list
                    $sql = "SELECT * FROM Admins WHERE Id=$id AND Name='$name' AND Password='$pass'";
                    $result = mysqli_query($conn, $sql);
                    $rows = mysqli_num_rows($result);
                    if ($rows == 1) {
                        $sql = "DELETE FROM Admins WHERE ID=$id";
                        if (mysqli_query($conn, $sql)) {
                            echo '<script language="javascript">';
                            echo 'alert("Admin Deleted From Records")';
                            echo '</script>';
                        }
                        else {
                            echo "Error Deleting Admin: " . mysqli_error($conn);
                        }
                    }
                    else {
                        echo "The entered credentials are not correct";
                    }
                }
            }
            else {
                echo "Passwords do not match";
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
        <title>Admin Add/Remove</title>
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
                <h2>Add/Remove Admin</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="cancel">
                    <table>
                        <tr>
                            <td>ID:</td>
                            <td><input type="number" name="id" placeholder="Enter ID of admin" required class="enterText"></td>
                        </tr>
                        <tr>
                            <td>Name:</td>
                            <td><input type="text" name="name" placeholder="Enter Name" required class="enterText"></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" name="password" placeholder="Enter Password" required class="enterText"></td>
                        </tr>
                        <tr>
                            <td>Re-Password:</td>
                            <td><input type="password" name="repassword" placeholder="Enter Password Again" required class="enterText"></td>
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
