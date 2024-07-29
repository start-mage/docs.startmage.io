<?php
$url = $_SERVER['REQUEST_URI'];
$url = str_replace('/docs/', '', $url);
if(file_exists($url . '.md')) {
    header("Status 200 OK");
    include 'index.html';
}else{
    header("Status: 404 Not Found");
    die('404');
}

?>