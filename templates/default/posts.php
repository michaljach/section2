<?php
foreach (get_posts(get_request('page')) as $key => $value) {
    echo '<article>' . render_markdown($value) . '</article>';
}
?>