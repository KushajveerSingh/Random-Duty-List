<?php
    session_start();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST['logout']) {
                $_SESSION['loggedin'] = false;
                header("Location:index.php");
                exit();
            }

            $buttonPressed = $_POST['action'];
            $category = $_POST['button'];

            if ($buttonPressed == "Add") {
                header("Location:addInList.php");
                exit();
            }
            elseif ($buttonPressed == "Remove") {
                header("Location:removeFromList.php");
                exit();
            }
            elseif ($buttonPressed == "Cancel") {
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
        <title>Edit List</title>
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
                <h1>Select Catgory</h1>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="submit" name="action" value="Add" class="inputButton">
                    <input type="submit" name="action" value="Remove" class="inputButton">
                    <input type="submit" name="action" value="Cancel" class="inputButton">
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
