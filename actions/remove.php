<?php

$id = $_POST['dataid'];

$fileContents = file_get_contents("../data/todo.json");
$todoList = [];
$outputArray = [];
$todoList = json_decode($fileContents, true);

foreach($todoList as $key=>$value){
    if($key == $id){
        print("im in");
        unset($todoList[$key]); 
        $outputArray['success'] = true;
        $outputArray['message'] = "File deleted successfuly!";
    }  
}

$fileContents = json_encode($todoList, true);

$fileContentsResult = file_put_contents("../data/todo.json", $fileContents);

echo (json_encode($outputArray));
?>

