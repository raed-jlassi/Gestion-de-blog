<!DOCTYPE html>
<html lang="en">


<head>
    <?php


    session_start();
    //PROTECT THE ROUTER
    if (empty($_SESSION["username"]) || empty($_SESSION["role"]) || $_SESSION["role"] != "visitor") {
        header("Location:http://localhost/app/auth/login/index.php");
    }
    require "../../../actions/utils/Dbconnection.php";
    //GET THE BLOGS FROM THE DB
    $cat_name = $_GET["catname"];

    $username = $_SESSION["username"];
    $stm = $conn->prepare("SELECT * FROM articles where catg_id=:catname order by date_blog DESC");
    $stm->bindParam(":catname", $cat_name);
    $stm->execute();
    $data = $stm->fetchAll(PDO::FETCH_ASSOC);


    //GET CATERGORYS FROM THE DB
    $stmCat = $conn->prepare("SELECT * from categories");
    $stmCat->execute() or die("err" . $stm->errorInfo());
    $Catgs = $stmCat->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Blogs</title>
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
                <a href="../index.php" class="hover:border-b hover:text-black/80 flex gap-2 ">
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
                <a href="../notification/index.php" class="hover:border-b hover:text-black/80 flex gap-2">
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
            <form action="../../../../app/actions/auth/logout.php" method="post">
                <input type="submit"
                    class="bg-white p-2 px-4 border border-red-300 text-black curseur-pointer transition-all hover:text-white hover:bg-red-300"
                    value="Log-out" />
            </form>
        </div>
        </div>
    </header>
    <!--CATEGORYS-->
    <nav class="px-20 py-5 border-b w-full h-fit">
        <!--GET ALL CATEGORYS-->
        <span class="text-lg mr-2 underline font-bold font-serif  text-nowrap">Categorys :</span>

        <span class=" w-[90%] flex gap-2 items-center p-1  overflow-x-scroll">
            <span class="border h-fit text-nowrap rounded-lg cursor-pointer  bg-black text-white transition-all p-2"><?php
            echo $cat_name;
            ?></span>
        </span>

    </nav>
    <!--blogs-->
    <main class="w-full py-5 p-24">
        <!--GET ALL THE BLOGS FROM THE DB-->
        <!--Card blog-->
        <?php
        foreach ($data as $row) {
            ?>

        <!--Card blog-->
        <a href="../blog.php?id=<?php echo $row['idarticles']; ?>&owner=<?php echo $row['blog_owner']; ?>&title=<?php echo $row['blog_title']; ?>&desc=<?php echo $row['blog_description']; ?>"
            class="block shadow-md w-full p-5 space-y-2 hover:shadow-lg transition-all">
            <div class="flex gap-2 items-center">
                <img src="../../../user.png" class="size-8" />
                <span class="text-md font-serif text-black/80"><?php echo $row['blog_owner']; ?></span>
                <span class="text-sm text-gray-500 font-serif">At :<?php echo $row["date_blog"]; ?></span>

            </div>
            <span class="text-sm text-gray-400">category:</span>

            <span
                class="text-sm text-white font-serif bg-black p-1 px-2 rounded-lg "><?php echo $row["catg_id"]; ?></span>
            <hr class="w-full text-black/20 mt-2" />
            <h1 class="text-2xl p-2 font-bold"><?php echo $row['blog_title']; ?></h1>
            <h1 class="text-sm text-black/50 px-2"><?php echo $row['blog_description']; ?></h1>
        </a>

        <?php
        }
        ?>

    </main>
</body>

</html>