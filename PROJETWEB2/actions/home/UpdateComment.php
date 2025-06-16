<?php
require "../utils/Dbconnection.php";
require "../utils/clean_inp.php";

$id = Clean_input($_GET["id"]);
$newComment = Clean_input($_POST["comment"]);

$stm = $conn->prepare("UPDATE comments set contenu=:comment WHERE idcomments=:id ;");
$stm->bindParam(":id", $id);
$stm->bindParam(":comment", $newComment);
$stm->execute();

//redirect the user to the page
header("Location:{$_SERVER["HTTP_REFERER"]}");

?>