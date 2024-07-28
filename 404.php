<?php
$url = $_SERVER['REQUEST_URI'];
echo $url;
if(file_exists($url)) {
    http_response_code(200);
    include 'index.html';
}else{
    http_response_code(404);
    die('404');
}

?>