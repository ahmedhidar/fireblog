<?php
function logged_in() {
    return (isset($_SESSION['user_id'])) ? true : false;
};

function isAdmin() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function redirect($url) {
    header("Location: $url");
    exit;
}
function highlightMentions(string $text): string {
    $safe = htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); 
    return nl2br( preg_replace( '/@([a-zA-Z0-9_]+)/', '<span class="font-bold text-purple-600">@$1</span>', $safe ) );
    }


function buildCommentTree(array $comments): array {
    $tree = [];
    $indexed = [];

    foreach ($comments as $comment) {
        $comment['children'] = [];
        $indexed[$comment['id']] = $comment;
    }

    foreach ($indexed as $id => &$comment) {
        if ($comment['parent_id'] === null) {
            $tree[] = &$comment;
        } else {
            $indexed[$comment['parent_id']]['children'][] = &$comment;
        }
    }
    unset($comment);

    return $tree;
}

function generate_slug(string $title): string {
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return rtrim($slug, '-');
}