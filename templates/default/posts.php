<?php
foreach (get_posts(get_request('page')) as $id => $post) {
    $time = round(str_word_count($post['content'])/100) > 0 ? round(str_word_count($post['content'])/100) : 1;
    echo '<article>';
    echo '<span class="info">' . $time . ' minute read — ' . $post['date'] . '</span>';
    echo render_markdown($post['content']);
    echo '</article>';
}
?>