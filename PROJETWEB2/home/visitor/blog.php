<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    //PROTECT THE ROUTER
    if (empty($_SESSION["username"]) || empty($_SESSION["role"]) || $_SESSION["role"] != "visitor") {
        header("Location:http://localhost/app/auth/login/index.php");
    }
    //GET the data blog from THE LINK
    require "../../actions/utils/clean_inp.php";
    require "../../actions/utils/Dbconnection.php";
    $id = Clean_input($_GET['id']);
    $owner = Clean_input($_GET['owner']);
    $title = Clean_input($_GET['title']);
    $desc = Clean_input($_GET['desc']);
    //GET THE TEXT for the blog FROM THE DB 
    $stm = $conn->prepare("SELECT blog_text from articles where idarticles=:id ");
    $stm->bindParam(":id", $id);
    $stm->execute();
    $data = $stm->fetch(PDO::FETCH_ASSOC);
    $text = $data["blog_text"];



    //GET COMMENTS FROM DB
    $stmComment = $conn->prepare("SELECT * from comments where id_art=:id order by date DESC");
    $stmComment->bindParam(":id", $id);
    $stmComment->execute();
    $Comments = $stmComment->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    serif: ["Merriweather", "serif"],
                    sans: ["Source Sans Pro", "sans-serif"],
                },
                colors: {
                    primary: "#1a8917",
                    dark: "#121212",
                },
            },
        },
    };
    </script>
    <title>Document</title>
</head>

<body>
    <!-- Header -->
    <header class="z-20 border-b border-black select-none backdrop-blur-sm sticky top-0">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-xl md:text-2xl font-serif">
                    BloogersHub</span>
                </h1>
            </div>
            <div class="space-x-20 font-sans flex">
                <a href="index.php" class="hover:border-b hover:text-black/80 flex gap-2 ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-book-open-text-icon lucide-book-open-text">
                        <path d="M12 7v14" />
                        <path d="M16 12h2" />
                        <path d="M16 8h2" />
                        <path
                            d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                        <path d="M6 12h2" />
                        <path d="M6 8h2" />
                    </svg>Blogs</a>
                <a href="./notification/index.php" class="hover:border-b hover:text-black/80 flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-bell-ring-icon lucide-bell-ring">
                        <path d="M10.268 21a2 2 0 0 0 3.464 0" />
                        <path d="M22 8c0-2.3-.8-4.3-2-6" />
                        <path
                            d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
                        <path d="M4 2C2.8 3.7 2 5.7 2 8" />
                    </svg>
                    Notifications</a>

            </div>
            <!--THE LOGOUT BUTTON-->
            <form action="../../../app/actions/auth/logout.php" method="post">
                <input type="submit"
                    class="bg-white p-2 px-4 border border-red-300 text-black curseur-pointer transition-all hover:text-white hover:bg-red-300"
                    value="Log-out" />
            </form>
        </div>
    </header>
    <main class="w-full h-fit p-24">

        <!--Card blog-->
        <div class="block h-fit shadow-md w-full p-5 space-y-2 hover:shadow-lg transition-all ">
            <div class="flex gap-2 items-center">
                <img src="../../user.png" class="size-8" alt="">
                <span class="text-md font-serif text-black/80"><?php echo $owner; ?></span>
            </div>
            <hr class="w-full text-black/20" />
            <h1 class="capitalize text-4xl font-serif p-2 font-bold"><?php echo $title; ?></h1>
            <h1 class="text-sm font-serif text-black/50 px-2"><?php echo $desc; ?></h1>
            <p class="p-2"> <?php echo $text; ?> </p>


            <!--ADD COMMENTS-->
            <form action="../../actions/home/CreateComment.php?id=<?php echo $id; ?>" method="post" class="flex gap-3">
                <input type="text" name="comment" class="outline-none border w-[90%] p-2 font-serif"
                    placeholder="Add a comment down Here">
                <input type="submit" value="post"
                    class="border px-8 bg-black/80 text-white font-serif cursor-pointer hover:bg-black transition-all">
            </form>


        </div>


        <!--GET COMMENTS-->
        <section class="p-5 h-[300px] shadow-sm  overflow-y-scroll rounded-md">
            <span class="font-bold underline">Comments:</span>
            <!--Comment card-->
            <?php foreach ($Comments as $Comment) {
                //JUST SHOW ALL THE COMMENTS THAT OWNED BY THE USER OR BY OTHERS IF THEIR STATUS IS ACCEPTED
                if (!($Comment["comment_owner"] != $_SESSION["username"] && $Comment["status"] != "accepted")) {
                    ?>
            <div class="flex flex-col gap-2 h-fit" id="comments">
                <div class="flex flex-col border-b border-gray-200 w-full p-2">
                    <div class="flex justify-between">
                        <div>
                            <div class="flex gap-2 items-center">
                                <img src="../../user.png" class="size-6" />
                                <span
                                    class="text-sm font-serif text-black/80"><?php echo $Comment["comment_owner"]; ?></span>
                                <span class="text-sm text-gray-500">At :<?php echo $Comment["date"]; ?></span>
                            </div>
                            <p class="p-2 text-sm font-bold font-serif"><?php echo $Comment["contenu"];
                                    ?></p>
                        </div>


                        <?php
                                //CHECK IF THE USER HAVE THE RIGHTT TO EDIT THE COMMENTS OR NOT
                                if ($Comment["comment_owner"] == $_SESSION["username"]) {
                                    ?>
                        <?php
                                    //the user can edit the comment only if it is pending
                                    if ($Comment["status"] == "pending") {
                                        ?>
                        <div class="flex items-center">
                            <!--DELETE COMMENTS FORM-->
                            <form action="../../actions/home/DeleteComment.php?id=<?php echo $Comment["idcomments"] ?>"
                                method="post" class="px-2">
                                <input type="submit"
                                    class="text-sm underline text-gray-400 cursor-pointer hover:text-red-400"
                                    value="Delete comment">
                            </form>
                            <!--EDIT COMMENTS BUTTON-->
                            <button onclick="Showprompt(<?php echo $Comment['idcomments']; ?>)"
                                class="text-sm underline text-gray-400 cursor-pointer hover:text-green-400">Edit
                                comment</button>

                            <!--UPDATE THE COMMENTS FORM-->
                            <section id="prompt<?php echo $Comment["idcomments"]; ?>"
                                class="transition-all bg-black/80 fixed top-0 left-0 z-50 w-full h-svh hidden flex-col items-center justify-center ">
                                <form
                                    action="../../actions/home/UpdateComment.php?id=<?php echo $Comment["idcomments"]; ?>"
                                    method="post" class="flex flex-col p-4 w-[500px] gap-3 bg-white">
                                    <div class="flex w-full justify-between">
                                        <legend class="font-bold ">Update the Comment</legend>
                                        <span class="text-xl cursor-pointer"
                                            onclick="Closeprompt(<?php echo $Comment['idcomments']; ?>)">X</span>
                                    </div>
                                    <input type="text" name="comment" class="outline-none border w-full p-2 font-serif"
                                        placeholder="Type the new comment">
                                    <input type="submit" value="Update"
                                        onclick="Closeprompt(<?php echo $Comment['idcomments']; ?>)"
                                        class="border px-8 p-2 bg-black/80 text-white font-serif cursor-pointer hover:bg-black transition-all">
                                </form>
                            </section>
                            <!--SHOW THE STATUS-->
                            <?php
                                    }

                                    if ($Comment["status"] == "pending") {
                                        echo "<span class='text-sm mx-3 bg-orange-300 p-1 px-2 rounded-lg text-white  h-fit'>pending</span>";
                                    } else if ($Comment["status"] == "accepted") {

                                        echo "<span class='text-sm mx-3 bg-green-300 p-1 px-2 rounded-lg text-white h-fit'>Accepted</span>";
                                    } else if ($Comment["status"] == "rejected") {

                                        echo "<span class='text-sm mx-3 bg-red-300 p-1 px-2 rounded-lg text-white  h-fit'>Rejected</span>";
                                    }
                                    ?>
                        </div>
                        <?php
                                } ?>

                    </div>
                </div>
            </div>
            </div>
            <?php }
            }
            ?>
        </section>
    </main>



</body>

<script>
function Showprompt(e) {

    document.getElementById("prompt" + e).style.display = "flex"

}

function Closeprompt() {
    window.location.reload()
    document.getElementById("prompt" + e).style.display = "none";
}
</script>

</html>