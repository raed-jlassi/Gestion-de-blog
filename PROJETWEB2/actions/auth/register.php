<?php
require "../utils/Dbconnection.php";
require "../utils/clean_inp.php";

$username = Clean_input($_POST["username"]);
$password = Clean_input($_POST["password"]);
$cpassword = Clean_input($_POST["Cpassword"]);
$role = Clean_input($_GET["status"]);


if ($password != $cpassword) {
    //redirect the user to the previos page
    echo "<script>
                alert('Check confirm password they are not the same as password')
                window.location.replace('http://localhost/app/auth/register/index.php?status={$role}');
            </script>";
} else {

    $sql = "INSERT INTO user (username, password, role) values(:name, :password, :role)";
    //prepare the statement
    $stm = $conn->prepare($sql);

    //crypt the password
    $password = password_hash($password, PASSWORD_DEFAULT);
    //add variables to the statement
    $stm->bindParam(":name", $username);
    $stm->bindParam(":password", $password);
    $stm->bindParam(":role", $role);


    //execute the query
    try {
        $stm->execute();
        echo "<script>
                window.location.replace('http://localhost/app/auth/login/index.php');
            </script>";
    } catch (PDOException $e) {
        echo "<script>
                    alert('Username existed try another one')
                    window.location.replace('http://localhost/app/auth/register/index.php?status={$role}');
        </script> ";
    }




}





?>