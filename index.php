<?php
require_once __DIR__ . '/includes/config/Database.php';

require_once __DIR__ . '/includes/functions/helper.php';
require_once __DIR__ . '/includes/models/Post.php';
include __DIR__ . '/includes/layout/header.php';

$conn = connect(); 
$posts = getPosts($conn, 'accepted');
?>

<body>
<div class="max-w-7xl mx-auto px-6 py-16">
    <h1 class="text-6xl font-black text-center mb-16 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
        Latest  Posts
    </h1>

    <?php if (empty($posts)): ?>
        <div class="text-center py-20">
            <p class="text-2xl text-gray-500">No posts yet. Be the first to write!</p>
            <?php if(logged_in()): ?>
                <a href="create_post.php" class="mt-6 inline-block px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl font-bold hover:scale-105 transition">
                    Write Your First Post
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php foreach($posts as $post): ?>
                <?php include 'includes/components/post_card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<!-- <?php //print_r($_SESSION['error_message'] ?? ''); ?> -->
<?php include 'includes/layout/footer.php'; ?>