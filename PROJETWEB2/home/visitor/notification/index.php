<!DOCTYPE html>
<html lang="en">
<?php
session_start();
//PROTECT THE ROUTER
if (empty($_SESSION["username"]) || empty($_SESSION["role"]) || $_SESSION["role"] != "visitor") {
    header("Location:http://localhost/app/auth/login/index.php");
}
//GET the data blog from THE LINK
require "../../../actions/utils/Dbconnection.php";
$owner = $_SESSION["username"];

//GET COMMENTS FROM DB
$stm = $conn->prepare("SELECT * from comments c, articles a where c.id_art=a.idarticles and c.comment_owner=:owner order by c.date DESC");
$stm->bindParam(":owner", $owner);
$stm->execute();
$Comments = $stm->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
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
    <title>Notifications</title>
</head>

<body>
    <!-- Header -->
    <header class="z-20 border-b border-black select-none backdrop-blur-sm sticky top-0">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-xl md:text-2xl font-serif">
                    BloogersHub
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
                <a href="" class="hover:border-b hover:text-black/80 flex gap-2">
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
    </header>
    <!--GET ONLY THE COMMENTS THAT HAVE STAUS PENDING-->
    <div class="flex flex-col gap-2" id="comments">
        <?php
        foreach ($Comments as $Comment) {
            ?>

        <!--Comment card-->
        <div class="flex flex-col border-b border-gray-200 w-full p-2">
            <h1 class="text-2xl m-2 font-serif font-bold">
                <?php echo $Comment["blog_title"]; ?>
            </h1>
            <div class="flex justify-between">
                <div class="flex gap-2 items-center">
                    <img src="../../../user.png" class="size-6" />
                    <span class="text-sm font-serif text-black/80 font-bold ">
                        <?php echo $Comment["comment_owner"]; ?>
                    </span>
                    <span class="text-sm text-gray-500 underline">At :<?php echo $Comment["date"]; ?></span>
                </div>

                <!--CHECK THE STATUES-->

                <?php
                    if ($Comment["status"] == "pending") {
                        echo "<span class='text-sm mx-3 bg-orange-300 p-1 px-2 rounded-lg text-white'>pending</span>";
                    } else if ($Comment["status"] == "accepted") {

                        echo "<span class='text-sm mx-3 bg-green-300 p-1 px-2 rounded-lg text-white'>Accepted</span>";
                    } else if ($Comment["status"] == "rejected") {

                        echo "<span class='text-sm mx-3 bg-red-300 p-1 px-2 rounded-lg text-white'>Rejected</span>";
                    }
                    ?>

            </div>

            <p class="p-2 text-md capitalize"><?php echo $Comment["contenu"]; ?></p>
        </div>
        <?php
        }
        ?>


    </div>
    </main>
</body>

</html>