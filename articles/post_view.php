    <article class="bg-white rounded-3xl shadow-2xl overflow-hidden mb-16">
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $post['user_id']): ?>
        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded"
           href="create_post.php?id=<?= $post['id'] ?>&action=edit">
            edit
        </a>
        <?php endif; ?>
        <?php if (!empty($post['cover_img']) && file_exists('uploads/' . $post['cover_img'])): ?>
            <img src="uploads/<?= $post['cover_img'] ?>"
                 alt="<?= htmlspecialchars($post['title']) ?>"
                 class="w-full h-96 object-cover">
        <?php endif; ?>

        <div class="p-10 md:p-16">
            <div class="flex flex-wrap items-center gap-4 text-gray-600 mb-8">
                <span class="font-bold text-purple-700">
                    <?= htmlspecialchars($post['username']) ?>
                </span>
                <span>•</span>
                <time><?= date('F j, Y', strtotime($post['created_at'])) ?></time>

                <?php if (!empty($post['cat_name'])): ?>
                    <span class="px-4 py-2 bg-purple-100 text-purple-800
                                 rounded-full text-sm font-bold">
                        <?= htmlspecialchars($post['cat_name']) ?>
                    </span>
                <?php endif; ?>
            </div>

            <h1 class="text-5xl font-black text-gray-900 mb-8 leading-tight">
                <?= htmlspecialchars($post['title']) ?>
            </h1>

            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </div>
        </div>
    </article>