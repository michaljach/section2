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
            if(pathinfo($value)['extension'] == 'md')
                $posts[] = file_get_contents('posts/' . $value);
        }
        return $posts;
    } else return array();
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
function render_markdown($text) {
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $text = preg_replace('/__(.+?)__/s', '<strong>$1</strong>', $text);
    $text = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);
    $text = preg_replace('/_([^_]+)_/', '<span style="text-decoration: underline;">$1</span>', $text);
    $text = preg_replace('/\*([^\*]+)\*/', '<em>$1</em>', $text);
    $text = preg_replace('/`(.*?)`/', '<code>$1</code>', $text);
    $text = preg_replace('/\/t/', '    ', $text);
    $text = preg_replace('/    (.*)/', '<code>$1</code>', $text);
    $text = preg_replace('/\n(&gt;|\>) (.*)/', '<blockquote>$2</blockquote>', $text);
    $text = preg_replace('/(######) (.*)/', '<h6>$2</h6>', $text);
    $text = preg_replace('/(#####) (.*)/', '<h5>$2</h5>', $text);
    $text = preg_replace('/(####) (.*)/', '<h4>$2</h4>', $text);
    $text = preg_replace('/(###) (.*)/', '<h3>$2</h3>', $text);
    $text = preg_replace('/(##) (.*)/', '<h2>$2</h2>', $text);
    $text = preg_replace('/(#) (.*)/', '<h1>$2</h1>', $text);
    $text = preg_replace('/\[([^\]]+)]\(([a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\)/i', '<a href="$2">$1</a>', $text);
    $text = str_replace('\r\n', '\n', $text);
    $text = str_replace('\r', '\n', $text);
    $text = '<p>' . str_replace("\n\n", '</p><p>', $text) . '</p>';
    $text = str_replace("\n", '<br />', $text);

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
} else if(intval(get_request('id'))){
    render_template('header');
    render_template('post');
    render_template('footer');
}
?>