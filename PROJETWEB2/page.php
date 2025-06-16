<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    //PROTECT THE ROUTE
    session_start();
    if (!empty($_SESSION["username"]) && !empty($_SESSION["role"])) {
        if ($_SESSION["role"] == "visitor") {
            header("Location:http://localhost/app/home/visitor/index.php");
        } else if ($_SESSION["role"] == "bloger") {
            header("Location:http://localhost/app/home/bloger/index.php");
        }
    }
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
    <title>Blogers</title>
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
            <div class="flex items-center space-x-4">
                <a href="/app/auth/login/index.php"
                    class="bg-white p-2 px-4 border border-red-300 text-black curseur-pointer transition-all hover:text-white hover:bg-red-300">Sign
                    In</a>
            </div>
        </div>
    </header>
    <!--Welcome Message-->
    <main class="flex flex-col h-svh bg-red-200 w-full items-center justify-center">
        <h1 class="w-[70%] mb-2 text-4xl font-serif text-center">
            Stay curious. Discover stories, thinking, and expertise. Join a
            community of readers and writers sharing ideas, perspectives, and
            stories that matter.
        </h1>
        <div class="text-gray-600 flex flex-col items-center justify center animate-pulse z-10">
            <p>Scroll Down to start</p>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-chevrons-down">
                <path d="m7 6 5 5 5-5" />
                <path d="m7 13 5 5 5-5" />
            </svg>
        </div>
    </main>
    <!--Choice Section-->
    <section class="flex flex-col gap-6 h-svh bg-white w-full items-center justify-center">
        <h1 class="mb-2 text-4xl font-serif text-center">
            How would you like to proceed?
        </h1>
        <!--Cards Section-->
        <div class="flex gap-10">
            <!--Visitor card-->
            <div class="shadow-md p-5 w-[400px] h-[400px] space-y-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-telescope p-2 rounded-full border">
                    <path
                        d="m10.065 12.493-6.18 1.318a.934.934 0 0 1-1.108-.702l-.537-2.15a1.07 1.07 0 0 1 .691-1.265l13.504-4.44" />
                    <path d="m13.56 11.747 4.332-.924" />
                    <path d="m16 21-3.105-6.21" />
                    <path
                        d="M16.485 5.94a2 2 0 0 1 1.455-2.425l1.09-.272a1 1 0 0 1 1.212.727l1.515 6.06a1 1 0 0 1-.727 1.213l-1.09.272a2 2 0 0 1-2.425-1.455z" />
                    <path d="m6.158 8.633 1.114 4.456" />
                    <path d="m8 21 3.105-6.21" />
                    <circle cx="12" cy="13" r="2" />
                </svg>
                <h1 class="text-lg font-bold">Enter as a Visitor</h1>
                <span class="text-gray-500 text-sm">Explore curated content from our community of writers. Discover new
                    ideas and perspectives.</span>
                <ul class="space-y-2 mt-5">
                    <li>✅ Read unlimited articles</li>
                    <li>✅ Add Comments and modify them</li>
                </ul>
                <a href="../app/auth/register/index.php?status=visitor"
                    class="hover:bg-black/80 hover:text-white transition-all font-serif border mt-20 w-full block text-center p-2">Continue
                    As a Visitor</a>
            </div>
            <!--Bloger card-->
            <div class="flex">
                <div class="shadow-md p-5 w-[400px] h-[400px] space-y-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-square-pen p-2 rounded-full border">
                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path
                            d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                    </svg>
                    <h1 class="text-lg font-bold">Enter as a Bloger</h1>
                    <span class="text-gray-500 text-sm">Share your ideas, stories, and expertise with our growing
                        community of readers.</span>
                    <ul class="space-y-2 mt-5">
                        <li>✅ Publish unlimited blogs</li>
                        <li>✅ Create Categories to Manage your blogs</li>
                        <li>✅ Accept Or delete comments that u d'ont like</li>
                    </ul>
                    <a href="../app/auth/register/index.php?status=bloger"
                        class="hover:bg-black/80 hover:text-white transition-all font-serif border mt-12 w-full block text-center p-2">Continue
                        As a Bloger</a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>