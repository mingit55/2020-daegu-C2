<?php
function dump(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function dd(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
    exit;
}

function user(){
    return isset($_SESSION['user']) ? $_SESSION['user'] : false;
}
function admin(){
    return user() && user()->user_id == "admin" ? user() : false;
}

function go($url, $message = ""){
    echo "<script>";
    if($message !== "") echo "alert('$message');";
    echo "location.href='$url';";
    echo "</script>";
    exit;
}

function back($message = ""){
    echo "<script>";
    if($message !== "") echo "alert('$message');";
    echo "history.back();";
    echo "</script>";
    exit;
}

function json_response($data){
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

function view($viewName, $data = []){
    extract($data);

    require VIEW."/header.php";
    require VIEW."/$viewName.php";
    require VIEW."/footer.php";
}

function checkEmpty(){
    foreach($_POST as $input){
        if(trim($input) === "")
            back("모든 정보를 입력해 주세요.");
    }
}

function extname($filename){
    return strtolower( substr($filename, strrpos($filename, ".")) );
}

function checkImage($filename){
    return array_search(extname($filename), [".jpg", ".png", ".gif"]) !== false;
}

function enc($output){
    return nl2br(str_replace(" ", "&nbsp;", htmlentities($output)));
}

function getTimeLine($str){
    $t_start = (int)substr($str, 0, 2);
    $t_end = (int)substr($str, 6, 2);
    $times = [];
    for($i = $t_start; $i <= $t_end; $i++){
        $times[] = "$i:00";
    }
    return $times;
}