<?php
include_once __DIR__ . '/../includes/layout/header.php';
include_once __DIR__ . '/../includes/models/Category.php';

include_once __DIR__ . '/../includes/config/Database.php';
$conn = connect();

$action = $_GET['action'] ?? 'create';
$postId = isset($_GET['id']) ? (int)$_GET['id'] : null;
if($action === 'edit' && $postId) {
    include_once __DIR__ . '/../includes/models/Post.php';
    $post = getPostById($conn, $postId);
}

$categories = getAllCategories($conn);
if (!logged_in()) {
    $_SESSION['error_message'] = "You must be logged in to create a post.";
    header("Location: /auth/login.php");
    exit();
}

?>
<section class="max-w-4xl mx-auto mt-12">
    <h2 class="text-4xl font-black text-gray-900 mb-10 text-center">
        Create New Post
    </h2>

    <div class="p-10 bg-gradient-to-br from-purple-50 via-pink-50 to-purple-50 
                rounded-3xl border-2 border-purple-200 shadow-2xl">

        <form action="../handlers/create_post_handler.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?php echo htmlspecialchars($action); ?>">
            <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($postId ?? ''); ?>">
            <!-- Title -->
            <div class="mb-8">
                <label for="title" class="block text-lg font-bold text-gray-800 mb-3">
                    Post Title
                </label>
                <input type="text" name="title" id="title" required
                    placeholder="Enter an engaging title..."
                    value="<?php echo htmlspecialchars($post['title'] ?? '') ?>"
                    class="w-full px-6 py-4 text-xl rounded-2xl border-2 border-purple-300 
                           focus:border-purple-600 focus:ring-4 focus:ring-purple-200 
                           transition shadow-sm bg-white">
            </div>


           
            <!-- Content -->
            <div class="mb-8">
                <label for="content" class="block text-lg font-bold text-gray-800 mb-3">
                    Content
                </label>
                <textarea name="content" id="content" rows="6" required
                    placeholder="Write your amazing post here... (supports @mentions and formatting)"
                    
                    class="w-full px-6 py-5 rounded-2xl border-2 border-purple-300 
                           focus:border-purple-600 focus:ring-4 focus:ring-purple-200 
                           transition text-lg resize-none bg-white prose max-w-none"><?php echo htmlspecialchars($post['content'] ?? '') ?></textarea>
            </div>

            <!-- Category & Status (side by side on larger screens) -->
            <div class="grid grid-cols-1 md:grid-cols-1 gap-8 mb-8">
                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-lg font-bold text-gray-800 mb-3">
                        Category
                    </label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-6 py-4 rounded-2xl border-2 border-purple-300 
                               focus:border-purple-600 focus:ring-4 focus:ring-purple-200 
                               transition shadow-sm bg-white">
                        <option value="">Select a category</option>
                        <?php
                        if(!empty($post['category_id'])) {
                            echo "<option value=\"{$post['category_id']}\" selected>" . htmlspecialchars($post['cat_name']) . "</option>";
                        }else{
                        foreach ($categories as $cat) {
                            echo "<option value=\"{$cat['id']}\">{$cat['name']}</option>";
                        }
                        }

                        ?>
                    </select>
                </div>

             

            <!-- Cover Image Upload -->
            <div class="mb-10">
                <label for="cover_img" class="block text-lg font-bold text-gray-800 mb-3">
                    Cover Image
                </label>
                <div class="border-4 border-dashed border-purple-300 rounded-3xl p-10 text-center 
                            bg-white bg-opacity-70 hover:bg-opacity-100 transition">
                    <input type="file" name="cover_img" id="cover_img" accept="image/*"
                        class="hidden">
                    <label for="cover_img" class="cursor-pointer">
                        <div class="text-6xl text-purple-400 mb-4">📷</div>
                        <p class="text-xl text-gray-700 font-semibold">
                            Click to upload cover image
                        </p>
                        <p class="text-sm text-gray-500 mt-2">
                            Recommended: 1200x630px (JPG, PNG)
                        </p>
                    </label>
                </div>
            </div>
            <input type="text" value="<?php echo htmlspecialchars($post['cover_img'] ?? '') ?>" name="img_path" hidden>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit"
                    class="px-16 py-6 bg-gradient-to-r from-purple-600 to-pink-600 
                           text-white font-black text-2xl rounded-3xl 
                           hover:scale-105 hover:shadow-2xl transition transform">
                    Publish Post
                </button>
            </div>

        </form>
    </div>
    <div> <?php echo $_SESSION['error_message'] ?? '' ?></div>
</section>
<?php
include_once __DIR__ . '/../includes/layout/footer.php';