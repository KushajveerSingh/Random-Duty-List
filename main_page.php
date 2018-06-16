<?php
    session_start();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        require 'server_init.php';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST['logout']) {
                header("Location:index.php");
                exit();
            }

            $buttonPressed = $_POST['button'];
            if ($buttonPressed == "Add Person") {
                header("Location:addPerson.php");
                exit();
            }
            elseif ($buttonPressed == "Remove Person") {
                header("Location:removePerson.php");
                exit();
            }
            elseif ($buttonPressed == "Generate List") {
                header("Location:generateList.php");
                exit();
            }
            elseif ($buttonPressed == "Get Today's List") {
                header("Location:getTodayList.php");
                exit();
            }
            elseif ($buttonPressed == "List of Free People") {
                header("Location:listFreePeople.php");
                exit();
            }
            elseif ($buttonPressed == "Edit Generated List") {
                header("Location:editList.php");
                exit();
            }
            elseif ($buttonPressed == "Admin Add/Remove") {
                header("Location:adminAddRemove.php");
                exit();
            }
            elseif ($buttonPressed == "Station Add/Remove") {
                header("Location:stationAddRemove.php");
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
        <title>Main Page</title>
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
                <h1>Select an Option</h1>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input type="submit" name="button" value="Add Person" class="inputButton"><br>
                    <input type="submit" name="button" value="Remove Person" class="inputButton"><br>
                    <input type="submit" name="button" value="Generate List" class="inputButton"><br>
                    <input type="submit" name="button" value="Get Today's List" class="inputButton"><br>
                    <input type="submit" name="button" value="Edit Generated List" class="inputButton"><br>
                    <input type="submit" name="button" value="List of Free People" class="inputButton"><br>
                    <input type="submit" name="button" value="Admin Add/Remove" class="inputButton"><br>
                    <input type="submit" name="button" value="Station Add/Remove" class="inputButton"><br>
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
