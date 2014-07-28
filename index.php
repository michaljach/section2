<?php
/*
* §2, Section2 - Fast, elegant, modern blogging
* @author: michaljach
* https://github.com/michaljach/section2
*/
function get_posts($page = 1, $per_page = 10){
    $page = $page == 0 ? 1 : $page;
    $files_array = array_diff(scandir('posts',1), array('..', '.'));
    $files_array = array_slice($files_array, $page*$per_page-$per_page, $per_page);
    if(!empty($files_array)){
        foreach ($files_array as $key => $value) {
            $info = pathinfo($value);
            if($info['extension'] == 'md'){
                $content = file_get_contents('posts/' . $value);
                $date = filemtime('posts/' . $value);
                $slug = str_replace('.md', '', $value);
                $time = round(str_word_count($content)/60) > 0 ? round(str_word_count($content)/60) : 1;

                echo '<article>';
                echo '<span>' . $time . ' minute read — ' . date('F j, Y', $date) . '</span>';
                echo '<h1 class="title"><a href="' . str_replace('.md', '', $value) . '">' . str_replace('#', '', strtok($content, "\n")) . '</a></h1>';
                $content = render_markdown(htmlspecialchars(substr($content, strpos($content, "\n")+1 )));
                if (strlen($content) > 700) {
                    $stringCut = substr($content, 0, 700);
                    echo substr($stringCut, 0, strrpos($stringCut, ' ')).'... <a href="' . str_replace('.md', '', $value) . '">Continue reading</a>'; 
                } else {
                    echo $content;
                }
                echo '</article>';
            }
        }
    } else echo 'No posts!';
}
function get_post($slug){
    if(file_exists('posts/' . $slug . '.md')){
        $content = file_get_contents('posts/' . $slug . '.md');
        $date = filemtime('posts/' . $slug . '.md');
        $time = round(str_word_count($content)/60) > 0 ? round(str_word_count($content)/60) : 1;
        echo '<article>';
        echo '<span class="info">' . $time . ' minute read — ' . date('F j, Y', $date) . '</span>';
        echo '<h1 class="title">' . str_replace('#', '', strtok($content, "\n")) . '</h1>';        
        echo render_markdown(htmlspecialchars(substr($content, strpos($content, "\n")+1 )));
        echo '</article>';
    }
}
function get_settings(){
    if(!file_exists('config.php')){
        echo 'install';
    } else {
        require_once('config.php');
    }
}
function get_request($param){
    if(isset($_GET[$param])){
        return $_GET[$param];
    } else return NULL;
}
function render_markdown($text){
    $rules = array (
        '/(#+) (.*)/' => sprintf ('<h%d>%s</h%d>', strlen('$1'), trim ('$2'), strlen('$1')),
        '/\!\[(.*)\]\((.*)\)/' => '<img src="$2" alt="$1">',
        '/\[([^\[]+)\]\(([^\)]+)\)/' => '<a href=\'\2\'>\1</a>',
        '/(\*\*|__)(.*?)\1/' => '<strong>\2</strong>',
        '/(\*|_)(.*?)\1/' => '<em>\2</em>',
        '/\~\~ (.*?) \~\~/' => '<del>\1</del>',
        '/\:\" (.*?) \"\:/' => '<q>\1</q>',
        '/`(.*?)`/' => '<code>\1</code>',
        '/\n    (.*)/' => sprintf ("<pre>%s</pre>", trim ('$1')),
        '/\n\* (.*)/' => sprintf ("<ul><li>%s</li></ul>", trim('$1')),
        '/\n[0-9]+\. (.*)/' => sprintf ("<ol><li>%s</li></ol>", trim ('$1')),
        '/\n>|\n&gt; (.*)/' => sprintf ("<blockquote>%s</blockquote>", trim ('$1')),
        '/\n-{5,}/' => "<hr />",
        '/\n([^\n]+)\n/' => sprintf ("<p>%s</p>", trim('$1')),
        '/<p><(ul|ol|li|h|p|bl)>/' => '<$1>',
        '/<\/(ul|ol|li|h|p|bl)><\/p>/' => '</$1>',
        '/<\/ul>\s?<ul>/' => '',
        '/<\/ol>\s?<ol>/' => '',
        '/<\/blockquote>\s?<blockquote>/' => "</br>",
        '/<\/code>\s?<code>/' => "</br>",
        '/<\/pre>\s?<pre>/' => "</br>"
    );
    $text = "\n" . $text . "\n";
    foreach ($rules as $regex => $replacement){
        $text = preg_replace ($regex, $replacement, $text);
    }
    return $text;
}
function render_template($template){
    include('templates/' . TEMPLATE . '/' . $template . '.php');
}
// Main
get_settings();
if(get_request('id') == 'admin'){

} else if(get_request('id') == NULL){
    render_template('header');
    render_template('posts');
    render_template('footer');
} else {
    render_template('header');
    render_template('post');
    render_template('footer');
}
?>