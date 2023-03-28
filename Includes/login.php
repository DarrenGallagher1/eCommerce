<!-- Apply sign in to database -->
<?php

if (isset($_POST["signInSubmit"])) {

    include("validationtest.php");

    session_start();
    $_SESSION["email"] = htmlspecialchars($_POST["signInEmail"]);
    $_SESSION["password"] = htmlspecialchars($_POST["signInPassword"]);

    loginValidation($_SESSION["email"], $_SESSION["password"]);

    $sqlConnection = mysqli_connect("localhost", "root", "", "dummyForm");
    $email = mysqli_real_escape_string($sqlConnection, $_POST["signInEmail"]);
    $password = mysqli_real_escape_string($sqlConnection, $_POST["signInPassword"]);

    if (mysqli_connect_errno()) {
        printf("Connection to DB failed: %s \n", mysqli_connect_error());
    } else {

        $sql = "SELECT * FROM form WHERE email = '$email' and password = '$password'";

        $res = mysqli_query($sqlConnection, $sql);
        $count = mysqli_num_rows($res);
        $array = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $userName = $array["name"];

        if ($count == 1) {
            session_start();
            unset($_SESSION["error"]);
            $_SESSION["userName"] = $userName;
            header("location: ../index.php");
        } else {
            $_SESSION["error"] = "Incorrect email or password";
            header("location: ../index.php");
        }
    }
} else {
    session_start();
    if(isset($_SESSION["error"])) {
        unset($_SESSION["error"]);
    }

    if(isset($_SESSION["email"])) {
        unset($_SESSION["email"]);
    }

    if(isset($_SESSION["password"])) {
        unset($_SESSION["password"]);
    }
    header("location: ../index.php");
}

?>