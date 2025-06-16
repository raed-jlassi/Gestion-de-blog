<?php
require "../utils/Dbconnection.php";
require "../utils/clean_inp.php";

$id = Clean_input($_GET["id"]);


$stm = $conn->prepare("UPDATE comments set status='accepted' WHERE idcomments=:id ;");
$stm->bindParam(":id", $id);

$stm->execute();
header("Location:{$_SERVER["HTTP_REFERER"]}");





?>