<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../utils/Dbconnection.php";
require "../utils/clean_inp.php";

$title = Clean_input($_POST["title"]);
$desc = Clean_input($_POST["desc"]);
$text = Clean_input($_POST["text"]);
$catg = Clean_input($_POST["catg"]);
$username = $_SESSION["username"];


//First we need to Check if the categorie exist or not if not we create a new one in the table of categories
$sqlSearchCatg = "SELECT cat_name FROM categories where cat_name=:catg ";
$stmSearchCatg = $conn->prepare($sqlSearchCatg);
$stmSearchCatg->bindParam(":catg", $catg);
$stmSearchCatg->execute();

$resultSearchCatg = $stmSearchCatg->fetch(PDO::FETCH_ASSOC);

if (!$resultSearchCatg["cat_name"]) {
    $stmCreateCatg = $conn->prepare("INSERT INTO categories (cat_name) values(:cat)");
    $stmCreateCatg->bindParam(":cat", $catg);
    try {
        $stmCreateCatg->execute();
    } catch (PDOException $e) {
        die("" . $e->getMessage());
    }
}

//then after cheking the categori we can add the articles

$sql = "INSERT INTO articles (blog_title, blog_description, blog_text, blog_owner, catg_id) values (:title, :desc, :text, :owner, :categ);";

//prepare the statement
$stm = $conn->prepare($sql);

$stm->bindParam(":title", $title);
$stm->bindParam(":desc", $desc);
$stm->bindParam(":text", $text);
$stm->bindParam(":owner", $username);
$stm->bindParam(":categ", $catg);

try {
    $stm->execute();
    echo "<script>alert('Blog Created Succefully !')</script>";
    header("Location:http://localhost/app/home/bloger/index.php");
} catch (PDOException $e) {
    echo "!! " . $e->getMessage();
}

?>