<?php

    session_start();

    if(isset($_POST["edit"]["delete"])) {

        unset($_SESSION["account"]["FirstName"]);

        $sqlConnection = mysqli_connect("localhost:3306", "root", "", "dummyForm");

        if (mysqli_connect_errno()) {
            printf ("Could not connect to DB: %s", mysqli_connect_error());
        } else {
            $queryString = "DELETE FROM account WHERE AccountID = '".$_POST["edit"]["id"]."'";
            $update = mysqli_query($sqlConnection, $queryString);

            if ($update) {
                if(isset($_POST["edit"])) {
                    unset($_POST["edit"]);
                }
            } 
        }
        mysqli_close($sqlConnection);
        header("location: http://localhost/website/index.php");
    } else if (isset($_POST["edit"]["submit"])) {

        $sqlConnection = mysqli_connect("localhost:3306", "root", "", "dummyForm");

        if (mysqli_connect_errno()) {
            printf ("Could not connect to DB: %s", mysqli_connect_error());
        } else {
            $queryString = "UPDATE account
                            SET FirstName = '".$_POST["edit"]["firstName"].
                                "', LastName = '".$_POST["edit"]["lastName"].
                                "', Street = '".$_POST["edit"]["street"].
                                "', City = '".$_POST["edit"]["city"].
                                "', Country = '".$_POST["edit"]["country"].
                                "', Postcode = '".$_POST["edit"]["postcode"].
                                "', Email = '".$_POST{"edit"}["email"].
                            "' WHERE AccountID = '".$_POST["edit"]["id"]."'";

            $update = mysqli_query($sqlConnection, $queryString);

            if ($update) {
                if(isset($_POST["edit"])) {
                    unset($_POST["edit"]);
                }
            }

            $queryString = "SELECT * FROM account WHERE AccountID = '".$_SESSION["account"]["AccountID"]."'";

            $update = mysqli_query($sqlConnection, $queryString);

            if ($update) {
                $array = mysqli_fetch_array($update, MYSQLI_ASSOC);
                $_SESSION["account"] = $array;
            }

            mysqli_close($sqlConnection);
            header("location: http://localhost/website/index.php");
        }
    } else if (isset($_POST["password"]["submit"]) && 
    $_POST["password"]["old"] == $_SESSION["account"]["Password"] &&
    $_POST["password"]["new"] == $_POST["password"]["confirm"]) {

        $sqlConnection = mysqli_connect("localhost:3306", "root", "", "dummyForm");

        if (mysqli_connect_errno()) {
            printf("Could not connect to DB: %S", mysqli_connect_error());
        } else {
            $queryString = "UPDATE account SET Password = '".$_POST["password"]["new"]."' WHERE AccountID = '".$POST["password"]["id"]."'";
            $update = mysqli_query($sqlConnection, $queryString);

            if ($update) {
                if (isset($_POST["password"])) {
                    unset($_POST["password"]);
                }
            }

            mysqli_close($sqlConnection);
            header("location: http://localhost/website/index.php");
        }
    }
?>