<!-- views/post_card.php -->
<div class="group bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border border-gray-100">

    <!-- Cover Image with fallback -->
    <div class="relative h-64 bg-gradient-to-br from-purple-100 to-pink-100 overflow-hidden">
        <?php if (!empty($post['cover_img']) && file_exists( $post['cover_img'])): ?>
            <a href="post.php?id=<?= $post['id'] ?>">
                <img src="<?= htmlspecialchars($post['cover_img']) ?>" 
                     alt="<?= htmlspecialchars($post['title']) ?>"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            </a>
        <?php else: ?>
            <!-- Beautiful fallback gradient + icon when no image -->
            <a href="/articles/post.php?id=<?= $post['id'] ?>" class="flex items-center justify-center h-full">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-4 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <p class="text-white/80 font-medium text-lg">No preview</p>
                </div>
            </a>
        <?php endif; ?>

        <!-- Category badge on image -->
        <?php if (!empty($post['cat_name'])): ?>
            <div class="absolute top-4 left-4">
                <span class="px-4 py-2 bg-purple-600 text-white text-sm font-bold rounded-full shadow-lg">
                    <?= htmlspecialchars($post['cat_name']) ?>
                </span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Content -->
    <div class="p-8">
        <div class="flex items-center gap-3 text-sm text-gray-500 mb-4">
            <span class="font-semibold text-purple-700"><?= htmlspecialchars($post['author']) ?></span>
            <span>•</span>
            <time><?= date('M j, Y', strtotime($post['created_at'])) ?></time>
        </div>

        <h3 class="text-2xl font-bold text-gray-900 mb-4 line-clamp-2 leading-tight">
            <a href="articles/post.php?id=<?= $post['id'] ?>" 
               class="hover:text-purple-600 transition-colors">
                <?= htmlspecialchars($post['title']) ?>
            </a>
        </h3>

        <p class="text-gray-600 line-clamp-3 mb-6">
            <?= htmlspecialchars(substr(strip_tags($post['content']), 0, 160)) ?>...
        </p>

        <a href="post.php?id=<?= $post['id'] ?>" 
           class="inline-flex items-center gap-2 text-purple-600 font-bold hover:font-bold hover:gap-4 transition-all">
            Read More
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</div>