<?php
require "../utils/Dbconnection.php";
require "../utils/clean_inp.php";

$id = Clean_input($_GET["id"]);

$stm = $conn->prepare("DELETE FROM comments WHERE idcomments=:id ;");
$stm->bindParam(":id", $id);
$stm->execute();
//redirect the user to the page
header("Location:{$_SERVER["HTTP_REFERER"]}");




?>