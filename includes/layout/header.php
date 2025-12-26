<?php
session_start();
require_once __DIR__ . '/../functions/helper.php';
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'My Epic Blog'; ?></title>

    <!-- Tailwind CSS via CDN (instant, no install) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .glass { backdrop-filter: blur(12px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">

<!-- Epic Header -->
<header class="gradient-bg shadow-2xl sticky top-0 z-50">
    <div class="container mx-auto px-6 py-5">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <a href="index.php" class="text-4xl font-black text-white tracking-tight hover:scale-105 transition">
                BLOG<span class="text-yellow-300">FIRE</span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-10">
                <a href="/index.php" class="text-white font-medium hover:text-yellow-300 transition text-lg">Home</a>
                <!-- <a href="/admin/build/pages/sign-in.php" class="text-white font-medium hover:text-yellow-300 transition text-lg">admin</a> -->
                <?php if(!logged_in()): ?>
                <a href="/articles/create_post.php" class="text-white font-medium hover:text-yellow-300 transition text-lg">Create Post</a>
                <?php endif; ?>

                <?php if (logged_in()): ?>
                    <a href="/articles/create_post.php" class="text-white font-medium hover:text-yellow-300 transition text-lg">Write</a>
                    <span class="text-yellow-200 font-semibold">Hello <?= htmlspecialchars($_SESSION['username']) ?></span>
                    <a href="/auth/logout.php" class="bg-white/20 glass px-6 py-3 rounded-full text-white font-bold hover:bg-white/30 transition">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="/auth/login.php" class="text-white font-medium hover:text-yellow-300 transition text-lg">Login</a>
                    <a href="/auth/register.php" class="bg-yellow-400 text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-yellow-300 transition shadow-lg">
                        Join Free
                    </a>
                <?php endif; ?>

                <?php if (!isAdmin()): ?>
                    <a href="/admin/build/pages/sign-in.php" class="bg-red-600 text-white px-6 py-3 rounded-full font-bold hover:bg-red-700 transition">
                        ADMIN PANEL
                    </a>
                <?php endif; ?>
                <?php if (isAdmin()): ?>
                    <a href="/admin/build/pages/dashboard.php" class="bg-red-600 text-white px-6 py-3 rounded-full font-bold hover:bg-red-700 transition">
                        ADMIN PANEL
                    </a>
                <?php endif; ?>
            </nav>

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-white text-3xl">Menu</button>
        </div>
    </div>
</header>

<main class="flex-1 container mx-auto px-6 py-12 max-w-5xl">