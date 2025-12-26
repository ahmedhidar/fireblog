<?php

require_once '../includes/functions/helper.php';



$commentsTree = buildCommentTree($comments);

function renderComments(array $comments, int $postId, int $level = 0)
{
    foreach ($comments as $c) {
?>
<div class="bg-gray-50 rounded-2xl shadow-sm mb-6 relative"
    style="margin-left: <?= $level > 0 ? '60px' : '0px' ?>;">

    <!-- Vertical connecting line (same position for all replies) -->
    <?php if ($level >= 1): ?>
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-purple-300 opacity-50"></div>
    <?php endif; ?>

    <div class="flex items-start gap-4 pl-12">

                <!-- Avatar -->
                <div
                    class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600
                           rounded-full flex items-center justify-center
                           text-white font-bold text-lg shadow-lg flex-shrink-0">
                    <?= strtoupper(substr($c['username'], 0, 2)) ?>
                </div>

                <div class="flex-1">

                    <!-- Username + Date -->
                    <div class="flex flex-wrap items-center gap-3 mb-3">
                        <p class="font-bold text-gray-900">
                            <?= htmlspecialchars($c['username']) ?>
                        </p>
                        <span class="text-sm text-gray-500">
                            <?= date('M j, Y \a\t g:ia', strtotime($c['created_at'])) ?>
                        </span>
                    </div>

                    <!-- Comment Content -->
                    <div class="text-gray-800 leading-relaxed mb-4 prose max-w-none">
                        <?= highlightMentions($c['content']) ?>
                    </div>

                    <!-- Reply Button -->
                    <?php if (logged_in()): ?>
                        <button
                            onclick="document.getElementById('reply-<?= $c['id'] ?>').classList.toggle('hidden')"
                            class="text-purple-600 font-semibold hover:underline text-sm mb-4 inline-block">
                            Reply
                        </button>

                        <!-- Reply Form -->
                        <div id="reply-<?= $c['id'] ?>" class="mt-4 hidden">
                            <form action="../handlers/add_comment_handler.php" method="POST"
                                class="bg-white  rounded-xl border border-purple-200">

                                <input type="hidden" name="post_id" value="<?= $postId ?>">
                                <input type="hidden" name="parent_id" value="<?= $c['id'] ?>">
                                <textarea name="content" rows="3" required
                                    placeholder="Write your reply..."
                                    class="w-full px-4 py-3 rounded-lg border
                                border-gray-300 focus:border-purple-500
                                focus:ring-2 focus:ring-purple-100 transition"><?= '@' . $c['username'] . ' ' ?></textarea>

                                <div class="mt-3 flex gap-3">
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-purple-600 text-white rounded-lg">
                                        Send Reply
                                    </button>
                                    <button type="button"
                                        onclick="this.closest('div').classList.add('hidden')"
                                        class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <!-- Children -->
        <?php if (!empty($c['children'])): ?>
            <?php renderComments($c['children'], $postId, $level + 1); ?>
        <?php endif; ?>
<?php
    }
}
?>
<?php
if (!empty($commentsTree)) {
    renderComments($commentsTree, $post['id']);
} else {
    echo '<p class="text-gray-500">No comments yet.</p>';
}
?>

<!-- Add Comment -->
<?php if (isset($_SESSION['user_id'])): ?>
    <div class="mt-12 p-8 bg-gradient-to-r from-purple-50 to-pink-50
                        rounded-3xl border-2 border-purple-200">
        <form action="../handlers/add_comment_handler.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
            <textarea name="content" rows="5" required
                placeholder="Share your thoughts..."
                class="w-full px-6 py-5 rounded-2xl border-2
                                     border-purple-300 focus:border-purple-600
                                     focus:ring-4 focus:ring-purple-200 transition
                                     text-lg resize-none"></textarea>

            <div class="mt-6 text-right">
                <button type="submit"
                    class="px-12 py-5 bg-gradient-to-r from-purple-600
                                       to-pink-600 text-white font-black text-xl
                                       rounded-2xl hover:scale-105 transition shadow-2xl">
                    Post Comment
                </button>
            </div>
        </form>
    </div>
    <?php print_r($comments) ?>
<?php else: ?>
    <div class="text-center py-16 bg-gray-50 rounded-3xl">
        <p class="text-2xl text-gray-600 mb-8">
            Want to join the conversation?
        </p>
        <a href="login.php"
            class="inline-block px-12 py-5 bg-gradient-to-r from-purple-600
                          to-pink-600 text-white font-black text-xl rounded-2xl
                          hover:scale-105 transition shadow-2xl">
            Login to Comment
        </a>
    </div>
<?php endif; ?>

</section>
</div>