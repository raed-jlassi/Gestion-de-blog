<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    session_start();
    //PROTECT THE ROUTER
    if (empty($_SESSION["username"]) || empty($_SESSION["role"]) || $_SESSION["role"] != "bloger") {
        header("Location:http://localhost/app/auth/login/index.php");
    }

    //GET the data blog from THE LINK
    require "../../actions/utils/clean_inp.php";
    require "../../actions/utils/Dbconnection.php";
    $id = Clean_input($_GET['id']);
    $owner = Clean_input($_GET['owner']);
    $title = Clean_input($_GET['title']);
    $desc = Clean_input($_GET['desc']);
    $catg = Clean_input($_GET['catg']);
    //GET THE TEXT for the blog FROM THE DB 
    $stm = $conn->prepare("SELECT blog_text from articles where idarticles=:id");
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
                <a href="./CreateBlog/index.php" class="hover:text-black/80 flex gap-2 items-end hover:border-b ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="23" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-square-pen">
                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path
                            d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                    </svg>Write</a>
            </div>
            <!--THE LOGOUT BUTTON-->
            <form action="../../../app/actions/auth/logout.php" method="post">
                <input type="submit"
                    class="bg-white p-2 px-4 border border-red-300 text-black curseur-pointer transition-all hover:text-white hover:bg-red-300"
                    value="Log-out" />
            </form>
        </div>
    </header>
    <main class="w-full h-svh p-24">
        <!--Card blog-->
        <div class="block shadow-md w-full p-5 space-y-2 hover:shadow-lg transition-all">
            <div class="flex  items-center justify-between">
                <div class="flex gap-2 items-center">
                    <img src="../../user.png" class="size-8" alt="">
                    <span class="text-md font-serif text-black/80"><?php echo $owner; ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <!--DELETE BLOG FORM-->
                    <form action="../../actions/home/DeleteBlog.php?id=<?php echo $id; ?>" method="post" class="px-2">
                        <input type="submit" class="text-sm underline text-gray-400 cursor-pointer hover:text-red-400"
                            value="Delete The Blog">
                    </form>
                    <!--UPDATE BLOG BUTTON-->
                    <button type="submit" onclick="Showprompt()"
                        class="text-sm underline text-gray-400 cursor-pointer hover:text-blue-400">Update
                        The Blog</button>
                    <!--UPDATE BLOG FORM-->

                    <div id="prompt"
                        class="transition-all bg-black/80 fixed top-0 left-0 z-50 w-full h-svh hidden flex-col items-center justify-center ">
                        <form action="../../actions/home/UpdateBlog.php?id=<?php echo $id ?>"
                            class="flex flex-col gap-3 bg-white p-5 w-[60%]" method="post">
                            <div class="text-right w-full cursor-pointer" onclick="Closeprompt()">X</div>
                            <input type="text" name="title" placeholder="Write the title" required
                                value="<?php echo $title; ?>"
                                class="w-full p-2 focus:border-b outline-none text-3xl font-serif">

                            <input type="text" name="catg" value="<?php echo $catg; ?>"
                                placeholder="Categorie exmp : science , computer science, astronomy ..." required
                                class="w-full p-2 focus:border-b outline-none text-xl font-serif">

                            <input type="text" name="desc" placeholder="Description (optional)"
                                value="<?php echo $desc; ?>"
                                class="w-full px-3 focus:border-b outline-none text-lg text-black/50">

                            <textarea name="text" placeholder="Type your text blog Here !"
                                class="w-full p-3 focus:border-b outline-none text-lg " rows="10"
                                required><?php echo $text; ?></textarea>
                            <input type="submit"
                                class="border p-2 px-5 w-[200px] cursor-pointer font-serif hover:bg-black/80 hover:text-white transition-all">
                        </form>
                    </div>


                </div>


            </div>
            <hr class="w-full text-black/20" />
            <h1 class="capitalize text-4xl font-serif p-2 font-bold"><?php echo $title; ?></h1>
            <h1 class="text-sm font-serif text-black/50 px-2"><?php echo $desc; ?></h1>
            <p class="p-2"> <?php echo $text; ?> </p>


        </div>
        <!--GET COMMENTS-->
        <section class="p-5 h-[300px] shadow-sm  overflow-y-scroll">
            <span class="font-bold underline">Comments:</span>
            <!--Comment card-->
            <?php
            foreach ($Comments as $Comment) {
                //CHECK IF COMMENT IS NOT PENDING SHOW HIM
                if ($Comment["status"] != "pending" && $Comment["status"] != "rejected") {
                    ?>
                    <div class="flex flex-col gap-2 h-fit" id="comments">
                        <div class="flex flex-col border-b border-gray-200 w-full p-2">
                            <div class="flex justify-between">
                                <div class="flex gap-2 items-center">
                                    <img src="../../user.png" class="size-6" />
                                    <span
                                        class="text-sm font-serif text-black/80"><?php echo $Comment["comment_owner"]; ?></span>
                                    <span class="text-sm text-gray-500">At :<?php echo $Comment["date"]; ?></span>

                                </div>
                            </div>
                            <p class="p-2 text-sm"><?php echo $Comment["contenu"]; ?></p>
                        </div>
                    </div>
                    </div>

                    <?php
                }
            } ?>
        </section>
    </main>

</body>

<script>
    function Showprompt() {
        document.getElementById("prompt").style.display = "flex";
    }

    function Closeprompt() {
        window.location.reload();
        document.getElementById("prompt").style.display = "none";
    }
</script>

</html>