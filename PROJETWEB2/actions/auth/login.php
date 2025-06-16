<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../utils/Dbconnection.php";
require "../utils/clean_inp.php";


$username = Clean_input($_POST["username"]);
$password = Clean_input($_POST["password"]);

$sql = "SELECT username, password, role from user where username=:username";

//PREPARE THE STATEMENT

$stm = $conn->prepare($sql);
$stm->bindParam(":username", $username);


//execute the query
$stm->execute();

$res = $stm->fetch(PDO::FETCH_ASSOC);

if (!$res["username"]) {
    //redirect the user to the login page if u d'ont found the username
    echo "<script>
                alert('username Incorrect')
                window.location.replace('http://localhost/app/auth/login/index.php');
        </script>;";

} else if (password_verify($password, $res["password"]) == true) {
    $role = $res["role"];

    //STORE USERNAME AND HIS ROLE IN SESSION SO WE CAN USE IT AGAIN IN OTHER PAGES
    $_SESSION["username"] = $username;
    $_SESSION["role"] = $role;


    //REDIRECT USER BY THEIR ROLE
    if ($role == 'bloger') {
        echo "<script>
                window.location.replace('http://localhost/app/home/bloger/index.php');
            </script>";
    } else {
        echo "<script>
                window.location.replace('http://localhost/app/home/visitor/index.php');
            </script>";
    }


} else {//If the password is incorrect
    echo "<script>
            alert('Password Incorrect')
            window.location.replace('http://localhost/app/auth/login/index.php');
    </script>";

}


?>