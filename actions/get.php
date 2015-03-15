<?php
    $fileContents = file_get_contents("../data/todo.json");//get the contents of our todo.json file with file_get_contents
    $outputArray = [];//make an output array
    $todoList = [];

    if(strlen($fileContents) > 0)  //if the strlen of our file contents is > 0, there is something to do!
    {
        $todoList = json_decode($fileContents, true);//json_decode the contents of the todo.json, make sure to convert it to an associative array with true as the second arguement for json_decode
        
        $html = []; //make an variable to hold our html output, set it to a blank string
        foreach($todoList as $key=>$value){  //loop through the elements of our todo array, fetching the key and record for each one
           
     $html[] = "<div id='container_div' data-id='".$key."'><div class='title'>".$value['title']."</div><div class= 'date'>".date('Y-M-D H:i:s', $value['date'])."</div><div class='details'>".nl2br($value['details'])."</div><button type='button' id='btn_delete' class='btn btn-danger'>Delete</button></div>";
                //make an html element set to contain our todo record, much like our student record from Student Grade Table;  It should include a data-id attribute with the key (for later deleting / editing), the title, the date converted to a human-readable format, and the todo details.  Make sure to use the nl2br() function on the details so it looks right in html
            //add the html element set to our html output variable
        }
            $outputArray['success'] = true; 
            $outputArray['html'] = $html;
        //add a success=true and    html elements to our output array.  html element should hold the generated HTML from above
    }
    else  //if the strlen was 0, there were no todo items
    {
        $outputArray['success'] = false;
        $outputArray['message'] = "There was no todo item to add!";
        //add a success=false condition and appropriate error message indicating there were no records
    }
    echo(json_encode($outputArray)); //json encode the output array and echo it
?>