<?php
    session_start();
    require 'server_init.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $adminId = $_POST['adminId'];
        $adminPass = $_POST['adminPass'];

        $sql = "SELECT * FROM Admins WHERE ID=$adminId AND Password=$adminPass";
        $result = mysqli_query($conn, $sql);
        // Check admin present or not
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['loggedin'] = true;
            header("Location:main_page.php");
            exit();
        }
        else {
            $_SESSION['loggedin'] = false;
            echo '<script language="javascript">';
            echo 'alert("Incorrect Details Entered")';
            echo '</script>';
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
        <title>Admin Login</title>
        <link rel="stylesheet" href="./CSS/style.css">
    </head>
    <body>
        <header>
            <center>
                <img src="./Images/main.png" alt="Chandigarh Police Logo" style="width:70px; height:90px; float:left; padding-left:25%">
                <h1 style="color:red; font-size:45px">Chandigarh Police</h1>
            </center>
        </header>

        <section class="rdl">
            <div>
                <center>
                    <h1 style="font-size:40px; padding-top:30px">RANDOM DUTY LIST</h1>
                </center>
            </div>
        </section>
        <section id="loginForm" style="margin-top:80px; padding-left:25%; font-size:20px" class="formView">
            <div class="container">
                <h1>Admin Login</h1>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <table>
                        <tr>
                            <td><label for="adminId">Id</label></td>
                            <td><input type="text" name="adminId" id="adminId" placeholder="Enter your name" required class="enterText"><br></td>
                        </tr>
                        <tr>
                            <td><label for="adminPass">Password</label></td>
                            <td><input type="password" name="adminPass" id="adminPass" placeholder="Enter your password" required class="enterText"><br></td>
                        </tr>
                    </table>
                    <input type="submit" name="login" value="Login" class="smallButtons">
                </form>
            </div>
        </section>
        
        <footer>
            <p>Punjab Engineering College, Sector-12, Chandigarh</p>
        </footer>
    </body>
</html>
