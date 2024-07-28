<?php
$url = $_SERVER['REQUEST_URI'];
$url = str_replace('/docs/', '', $url);
if(file_exists($url . '.md')) {
    http_response_code(200);
    include 'index.html';
}else{
    http_response_code(404);
    die('404');
}

?>