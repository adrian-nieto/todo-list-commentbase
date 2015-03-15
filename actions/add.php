<?php
require_once('../includes/functions.php'); //require the functions.php file, make sure it is only added one time
$errorArray = array(); //create an array for error messages
$outputArray = array(); //create an array for output

if(isset($_POST))  //check if the post variable exists
{
    if($_POST['title'] == '')  //check if the title is an empty string
    {
        $errorArray['title'] = "There is no title!"; //add to the error array, set the title to an appropriate error message: $error['title']='your message'
    }
    if($_POST['date'] == '') //chek if the date is an empty string
    {
        $errorArray['date'] = "There is no date!";//add to the error array, set the date to an appropriate error message
    }
    else //if the date is not blank
    {
        $timestamp = strtotime($_POST['date']);//convert the date string to a utime with strtotime
        if($timestamp == false){   //if the utime is false, the date string wasn't valid, and we display an error
            $errorArray['date'] = "The date is not valid!";//add to the error array, set the date to an appropirate error message
        }
        else if($timestamp < time()) //else if the utime is less than now (date set in past).  can find current time with time()
        {
            $errorArray['date'] = "Date is set in the past!";//add to the error array, set the date to an appropriate error message
        }
    }
    if($_POST['details'] == '') //if the defails are blank
    {
            $errorArray['details'] = "The are no details!";//add to the error array, set the date to an appropriate error message
    }

    if(empty($errorArray)){ 
        //if there were no errors, ie the error array has no elements
        $todoItem = [
            'title' => $_POST['title'],
            'date' => $timestamp,
            'details' => $_POST['details']
        ]; //make an associative array to hold the pieces of our date, the title, the date (converted to a utime), and the etails
        $fileContents = file_get_contents("../data/todo.json"); //get the contents of our todo.json file with file_get_contents.  This is so we can add to it if it exists
        if(strlen($fileContents) == 0){  //if the length of the file's contents are 0 (ie the file was empty)
            $todoList = [];//make a variable to hold our list's associative array
        }
        else{  //if the length is not 0, 
           $todoList = json_decode($fileContents, true); 
        //json_decode the file's contents.  make sure to use "true" in the second argument so that the output is an associative array instead of standard object
        }
        $listName = $timestamp . generateRandomString();   //make a name for this record from: concatenate the utime with a random string, so we have unique IDs
            $todoList[$listName] = $todoItem; // add a new associative array to our todo.json array, key=name generated on line above, and value is the array generated from the input data
        $fileContents = json_encode($todoList, true);//json encode the modified list array, so we can replace the original file
        $fileContentsResult = file_put_contents("../data/todo.json", $fileContents); //use file_put_contents to replace the contents of the todo.json with our json_encoded object
        if($fileContentsResult > 0)  //test if the result of the file add is > 0.  If it is 0, the file add failed.
        {
            $outputArray['success'] = true; //if it was greater than 0, we had a successful add.  add a success field to our output array               with a boolean value of true
            $outputArray['message'] = "Files uploaded successfuly!";//add a successful message to our output array
        }
        else //if the result was not greater than 0, there was an error saving the file
        {
            $outputArray['success'] = false; // add a success field to our output array, and set it to false
            $outputArray['meessage'] = "Error uploading file!"; //give an appropriate message indicating failure
        }
    }
    else //if error count > 0, we had an error and need to report it back to the page
    {
        $outputArray['success'] = false;// add a success field to our output array, and set it to false
        $outputArray['message'] = "There were errors!"; //give an appropriate message indicating failure
        $outputArray['errors'] = $errorArray; //add our error array to a key in our output array, so we can report exact errors and/or show appropriate errors on different inputs
    }
}
else //post wasn't set, no data was available
{
    $outputArray['success'] = false;    // add a success field to our output array, and set it to false
    $outputArray['message'] = "Post was not set!"; //give an appropriate message indicating failure
}
    echo (json_encode($outputArray));//json_encode our output array, and echo it
?>