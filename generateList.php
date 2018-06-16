<?php
    session_start();


    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        require 'server_init.php';

        function sample_people ($A, $k, $start, $categoryName) {
            /*
                A -> Input array containing the id's of the poeple and their status (free=1 or not free=0)
                k -> Number of people to assign at each station
                start -> Value that we get from StartIndex to see which person is the first free person in the list
                categoryName -> Like categoryA, categoryB
            */
            $A_keys = array_keys($A);
            $A_values = array_values($A);
            $conn = $GLOBALS['conn'];
            $num_groups = $GLOBALS['num_groups'];

            if ($categoryName == "CategoryA") {
                $randomTable = "RandomListA";
            }
            elseif ($categoryName == "CategoryB") {
                $randomTable = "RandomListB";
            }
            elseif ($categoryName == "CategoryC") {
                $randomTable = "RandomListC";
            }

            // Temp start would contain our start value in the function and then in the end it woudl update the start value in the database
            // i -> our iterator index for the input array A
            // num_groups -> Number of stations that we have to assign to
            // result -> array to store the list of assigned poeple
            // update_start -> indicator that tells when to update start
            $temp_start = $start;
            $i = $start;
            $num_left = $k*$num_groups;
            $update_start = true;
            $result = array();

            while ($num_left > 0) {
                // Assign the person with free=1
                if ($A_values[$i] == 1) {
                    array_push($result, $A_keys[$i]);
                    $num_left--;

                    // Update the free value in the random table also
                    $sql = "UPDATE $randomTable SET Free=0 WHERE ID=$A_keys[$i]";
                    if (!mysqli_query($conn, $sql)) {
                        echo "Error updating free: " . mysqli_error($conn);
                    }

                    $i++;
                    // Update temp_start only if update_start is true
                    if ($update_start) {
                        $temp_start = $i;

                    }
                }
                else {
                    // Just a safe check to ensure that start does not miss any person in the list
                    if ($update_start) {
                        $temp_start = $i;
                        $update_start = false;
                    }
                    $i++;
                }

                if ($i >= count($A_keys)) {
                    // Our work is finished if num_left=0
                    if ($num_left == 0) {
                        $temp_start = 0;
                    }
                    // if some people are left to assign shuffle the list again and assign remaining people
                    else {
                        // Shuflle the array
                        for ($iter=0; $iter<count($A_keys); $iter++) {
                            $temp_key = $A_keys[$iter];
                            $temp_value = $A_values[$iter];
                            $randomIndex = mt_rand(0, count($A_keys) - 1);
                            $A_keys[$iter] = $A_keys[$randomIndex];
                            $A_values[$iter] = $A_values[$randomIndex];
                            $A_keys[$randomIndex] = $temp_key;
                            $A_values[$randomIndex] = $temp_value;
                        }

                        // Delete the previous list from the random table
                        $sql = "DELETE FROM $randomTable";
                        if (!mysqli_query($conn, $sql)) {
                            echo "Error deleting records: " . mysqli_error($conn);
                        }

                        // Insert your new shuffled randomList back to the randomTable
                        for ($iter=0; $iter<count($A_keys); $iter++) {
                            $sql = "INSERT INTO $randomTable VALUES ('$A_keys[$iter]', 1)";
                            if (!mysqli_query($conn, $sql)) {
                                echo "Error inserting aagin: " . mysqli_error($conn) . "</br>";
                            }
                        }

                        $A = array();
                        for ($iter=0; $iter<count($A_keys); $iter++) {
                            $A[$A_keys[$iter]] = $A_values[$iter];
                        }

                        $A_keys = array_keys($A);
                        $A_values = array_values($A);
                        $i = 0;
                        $update_start = true;
                        $temp_start = 0;

                        while ($num_left > 0) {
                            // If you have already included the person from the previous list,
                            // do not include it again and store it's index as the start value
                            if (in_array($A_keys[$i], $result)) {
                                if ($update_start) {
                                    $temp_start = $i;
                                    $update_start = false;
                                }
                                $i++;
                            }
                            else {
                                array_push($result, $A_keys[$i]);
                                $sql = "UPDATE $randomTable SET Free=0 WHERE ID=$A_keys[$i]";
                                if (!mysqli_query($conn, $sql)) {
                                    echo "Error updating free: " . mysqli_error($conn);
                                }
                                $i++;

                                if ($update_start) {
                                    $temp_start = $i;
                                }
                                $num_left--;
                            }
                        }
                    }
                }
            }

            // Update start value in the database
            $sql = "UPDATE StartIndex SET StartValue=$temp_start WHERE CategoryName='$categoryName'";
            if (!mysqli_query($conn, $sql)) {
                echo "Error udpating StartIndex: " . mysqli_error($conn);
            }
            return $result;
        }

        function insert_assigned_list ($A, $k, $category) {
            /*
                A -> Input array containing the id's of the poeple and their status (free=1 or not free=0)
                k -> Number of people to assign at each station
                categoryName -> Like categoryA, categoryB

               Assign the list of the people from the result array that we got from the previous function to
               the assigned tables.
            */
            $currentDate = $GLOBALS['currentDate'];
            $conn = $GLOBALS['conn'];
            $num_groups = $GLOBALS['num_groups'];

            if ($category == "CategoryA") {
                $assignTable = "AssignedA";
                $randomTable = "RandomListA";
            }
            elseif ($category == "CategoryB") {
                $assignTable = "AssignedB";
                $randomTable = "RandomListB";
            }
            elseif ($category == "CategoryC") {
                $assignTable = "AssignedC";
                $randomTable = "RandomListC";
            }

            // Get the station names and station address
            $stationInfo = array();
            $sql = "SELECT * FROM Stations";
            $result = mysqli_query($conn, $sql);
            while ($rows = mysqli_fetch_assoc($result)) {
                $temp = array($rows["Name"], $rows["Address"]);
                array_push($stationInfo, $temp);
            }

            // We have a list of k*num_of_stations and now we divide the people equally to all the
            // stations sequentially from the list A
            for ($a=0; $a<$num_groups; $a++) {
                $stationName = $stationInfo[$a][0];
                $stationAddress = $stationInfo[$a][1];
                for ($iter=$a*$k; $iter<$a*$k + $k; $iter++) {
                    $sql = "INSERT INTO $assignTable (ID, FirstName, LastName, Date, StationName, StationAddress) SELECT ID, FirstName, LastName, '$currentDate', '$stationName', '$stationAddress' FROM $category WHERE ID=$A[$iter]";
                    if (!mysqli_query($conn, $sql)) {
                        echo "Error assigning People: " . mysqli_error($conn) . "</br>";
                    }
                }
            }
        }   // funcion end

        /*
            Main code begins
        */

        // Check if list if already generated, if yes give error message
        $sql = "SELECT COUNT(*) AS NumRows FROM AssignedA WHERE Date='$currentDate'";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_assoc($result)['NumRows'];
        if ($rows > 0) {
            echo "list already generated";
        }
        else {
            $sql1 = "SELECT * FROM RandomListA";
            $sql2 = "SELECT * FROM RandomListB";
            $sql3 = "SELECT * FROM RandomListC";
            $sql4 = "SELECT StartValue FROM StartIndex WHERE CategoryName='CategoryA'";
            $sql5 = "SELECT StartValue FROM StartIndex WHERE CategoryName='CategoryB'";
            $sql6 = "SELECT StartValue FROM StartIndex WHERE CategoryName='CategoryC'";
            $sql7 = "SELECT COUNT(Name) AS Num_Stations FROM Stations";

            $result1 = mysqli_query($conn, $sql1);
            $result2 = mysqli_query($conn, $sql2);
            $result3 = mysqli_query($conn, $sql3);
            $result4 = mysqli_query($conn, $sql4);
            $result5 = mysqli_query($conn, $sql5);
            $result6 = mysqli_query($conn, $sql6);
            $result7 = mysqli_query($conn, $sql7);

            $A_categoryA = array();
            $A_categoryB = array();
            $A_categoryC = array();
            $start_categoryA = 0;
            $start_categoryB = 0;
            $start_categoryC = 0;
            $num_groups = 0;

            while ($rows = mysqli_fetch_assoc($result1)) {
                $A_categoryA[$rows["ID"]] = $rows["Free"];
            }
            while ($rows = mysqli_fetch_assoc($result2)) {
                $A_categoryB[$rows["ID"]] = $rows["Free"];
            }
            while ($rows = mysqli_fetch_assoc($result3)) {
                $A_categoryC[$rows["ID"]] = $rows["Free"];
            }
            $start_categoryA = mysqli_fetch_assoc($result4)["StartValue"];
            $start_categoryB = mysqli_fetch_assoc($result5)["StartValue"];
            $start_categoryC = mysqli_fetch_assoc($result6)["StartValue"];
            $num_groups = mysqli_fetch_assoc($result7)['Num_Stations'];

            $result1 = sample_people($A_categoryA, 2, $start_categoryA, "CategoryA");
            $result2 = sample_people($A_categoryB, 4, $start_categoryB, "CategoryB");
            $result3 = sample_people($A_categoryC, 3, $start_categoryC, "CategoryC");

            insert_assigned_list($result1, 2, "CategoryA");
            insert_assigned_list($result2, 4, "CategoryB");
            insert_assigned_list($result3, 3, "CategoryC");

            echo "List Generated";
        }
    }
    else {
        header("Location:index.php");
        exit();
    }
    ?>
