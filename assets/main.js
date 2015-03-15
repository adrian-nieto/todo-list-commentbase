$('document').ready(function(){
    var main_content = $('#main_content');
    
    

    
    //when the document is ready
    $("#save_task").click(function(){  //add click handler to save_task button

        var todoadd = $("#todo-add");
        var form_data={
            title:todoadd.find("input[name=title]").val(),
date:todoadd.find("input[name=date]").val(),
details:todoadd.find("textarea[name=details]").val(),
        }//get all the values from the form and add them to our data object for sending
        $.ajax(
        {
            url: 'actions/add.php',//send our data to the add.php file
            data: form_data, //give it the form data
            dataType: 'json', //expect json data back
            cache: false,//do not let the response be cached
            method: 'POST', //use POST to send it
            success: function(data){ //and do something when the response comes back
               console.log(data); //success is achieved!
              
                $("#display_refresh").click();
            
            }
        }); 
        
            
    }); //end of click handler
    
 //end of ready function
    
    
    $("#display_refresh").click(function(){  //add a click handler to our data display button

        $.ajax( 
        {
            url: 'actions/get.php',  //get our data from the get.php file
            dataType: 'json', //expect json data back from get.php
            cache: false, //do not cache the result
            method: 'POST',  //use the post method
            success: function(data){  //do something when we get data back
                if(data.success)
                {
                    $("#todo-display > .display_container").html(data.html); //take the html object of the data object, and put it into the display container
                    
                }
            }
        });
            
    });
    
    $("#display_refresh").click();
    
        main_content.on('click', '#btn_delete', function(){
    var listName =$(this).parent().attr('data-id');
        console.log(listName);
    var dataID = {
            dataid: listName   
        }
    
        $.ajax({
           
            url: 'actions/remove.php',
            data: dataID,
            dataType: 'json',
            cache: false, 
            method: 'POST',
            success: function(data){
                console.log(data);
                console.log("Deleted!");
                $("#display_refresh").click();
                
            },
            failure: function(){
             alert("Didnt receive anything back");
            }
        });
        
     alert("im in the call");
    });
     $("#display_refresh").click();
    
});
    

