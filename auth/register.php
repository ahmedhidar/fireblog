<?php
// require_once '../includes/config/Database.php';
require_once '../includes/functions/helper.php';
if (logged_in()) redirect('index.php');

$pageTitle = "register";
include '../includes/layout/header.php';
?>

<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full">

        <div class="text-center mb-10">
            <h2 class="text-5xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                Join Now
            </h2>
        </div>

        <!-- Show messages -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="bg-red-100 border-red-500 text-red-700 px-6 py-4 rounded-xl mb-6 text-center font-medium">
                <?= $_SESSION['error_message'] ?? '' ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="bg-green-100 border-green-500 text-green-700 px-6 py-4 rounded-xl mb-6 text-center font-medium">
                <?= $_SESSION['success_message'] ?? '' ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <form action="../handlers/register_handler.php" method="POST"
                enctype="multipart/form-data"
            class="bg-white/80 backdrop-blur-lg p-10 rounded-3xl shadow-2xl">
            <div class="space-y-6">

                <input type="text" name="username" required placeholder="Username"
                    class="w-full px-5 py-4 rounded-xl border focus:border-purple-600 focus:ring-4 focus:ring-purple-200 transition text-lg">

                <input type="email" name="email" required placeholder="email"
                    class="w-full px-5 py-4 rounded-xl border focus:border-purple-600 focus:ring-4 focus:ring-purple-200 transition text-lg">
                    <!-- image -->
                      <div class="mb-10">
                <label for="avatar" class="block text-lg font-bold text-gray-800 mb-3">
                    Avatar Image
                </label>
                <div class="border-4 border-dashed border-purple-300 rounded-3xl p-10 text-center 
                            bg-white bg-opacity-70 hover:bg-opacity-100 transition">
                    <input type="file" name="avatar" id="avatar" accept="image/*"
                        class="hidden">
                    <label for="avatar" class="cursor-pointer">
                        <div class="text-6xl text-purple-400 mb-4">📷</div>
                        <p class="text-xl text-gray-700 font-semibold">
                            Click to upload avatar image
                        </p>
                        <p class="text-sm text-gray-500 mt-2">
                            Recommended: 1200x630px (JPG, PNG)
                        </p>
                    </label>
                </div>
            </div>
                <input type="password" name="password" required placeholder="Password"
                    class="w-full px-5 py-4 rounded-xl border focus:border-purple-600 focus:ring-4 focus:ring-purple-200 transition text-lg">

    <button type="submit" class="w-full mt-8 py-5 bg-gradient-to-r from-purple-600 to-pink-600 text-white font-bold text-xl rounded-xl hover:scale-105 transition shadow-lg">
        Login Now
    </button>
    </form>

    <p class="text-center mt-8 text-gray-600">
        No account? <a href="register.php" class="font-bold text-purple-600 hover:underline">Register free</a>
    </p>
</div>
</div>

<?php include '../includes/layout/footer.php'; ?>