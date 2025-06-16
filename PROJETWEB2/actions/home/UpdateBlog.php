<?php
require "../utils/Dbconnection.php";
require "../utils/clean_inp.php";

$id = Clean_input($_GET["id"]);
$title = Clean_input($_POST["title"]);
$desc = Clean_input($_POST["desc"]);
$text = Clean_input($_POST["text"]);
$catg = Clean_input($_POST["catg"]);
echo "" . $id . "" . $title . "" . $desc . "" . $catg . "" . $text . "";
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




//NOW WE CAN UPDATE

$stm = $conn->prepare("UPDATE articles set blog_title=:title, blog_description=:desc, blog_text=:text, catg_id=:catg WHERE idarticles=:id ;");
$stm->bindParam(":id", $id);
$stm->bindParam(":title", $title);
$stm->bindParam(":desc", $desc);
$stm->bindParam(":text", $text);
$stm->bindParam(":catg", $catg);

$stm->execute() or die("errr" . $stm->errorCode());
//redirect the user to the page

header("Location:http://localhost/app/home/bloger/blog.php?id={$id}&owner={$_SESSION["username"]}&title={$title}&desc={$desc}&catg={$catg}");

?>