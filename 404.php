<?php
$url = $_SERVER['REQUEST_URI'];

if(file_exists($url . '.md')) {
    http_response_code(200);
    include 'index.html';
}else{
    http_response_code(404);
    die('404');
}

?>