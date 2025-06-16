<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../utils/Dbconnection.php";
require "../utils/clean_inp.php";

$id_blog = Clean_input($_GET["id"]);
$contenu = Clean_input($_POST["comment"]);
$comment_author = $_SESSION["username"];


foreach ($_SERVER as $key => $value) {
    echo "$key" . " = " . $value . "<br>";
}

$stm = $conn->prepare("INSERT INTO comments (contenu, comment_owner, id_art) values (:text, :owner, :idblog);");
$stm->bindParam(":text", $contenu);
$stm->bindParam(":owner", $comment_author);
$stm->bindParam(":idblog", $id_blog);


$stm->execute() or die("" . $stm->errorInfo());
//after creating the comment redierect to the blog page
header("Location:{$_SERVER["HTTP_REFERER"]}");

?>