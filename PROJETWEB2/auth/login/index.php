<!DOCTYPE html>
<html lang="en">
<?php
session_start();
//PROTECT THE ROUTER
if (!empty($_SESSION["username"]) && !empty($_SESSION["role"])) {
    if ($_SESSION["role"] == "visitor") {
        header("Location:http://localhost/app/home/visitor/index.php");
    } else if ($_SESSION["role"] == "bloger") {
        header("Location:http://localhost/app/home/bloger/index.php");
    }
}
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
    <title>Login</title>
</head>

<body>
    <!-- Header -->
    <header class="z-20 border-b border-black select-none backdrop-blur-sm sticky top-0">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-xl md:text-2xl font-serif">
                    Bloogers<span class="text-primary">Hub</span>
                </h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/app/page.php"
                    class="bg-white p-2 px-4 border border-red-300 text-black curseur-pointer flex gap-2 transition-all hover:text-white hover:bg-red-300">Go
                    back to the Welcome page<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-arrow-left-from-line">
                        <path d="m9 6-6 6 6 6" />
                        <path d="M3 12h14" />
                        <path d="M21 19V5" />
                    </svg></a>
            </div>
        </div>
    </header>

    <main class="flex items-center justify-center w-full p-24">
        <form action="../../actions/auth/login.php" method="post"
            class="text-center flex flex-col shadow-md p-10 gap-10 w-[500px]">
            <div>
                <legend class="font-serif font-bold text-2xl">Welcome Back</legend>
                <span class="text-sm text-gray-500">Sign in to access your account</span>
            </div>
            <input type="text" class="border-b outline-none font-serif text-md p-1" placeholder="Username"
                name="username" required /><input type="password" class="border-b outline-none font-serif text-md p-1"
                placeholder="*********" name="password" required />
            <input type="submit" class="border p-2 hover:bg-black/80 hover:text-white cursor-pointer transition-all"
                value="Login" />
        </form>
    </main>
</body>

</html>