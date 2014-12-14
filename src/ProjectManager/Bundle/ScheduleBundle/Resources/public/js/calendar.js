function addEvent(obj, event, fct) {
    if (obj.attachEvent)
        obj.attachEvent("on" + event, fct);
    else
        obj.addEventListener(event, fct, true);
}

function updateCalendar(){

    $( ".user_tasks" ).each(function(  ) {
        //Get user information
        var divId = $( this ).attr('id');
        var userId = divId.substring(divId.indexOf('_')+1, divId.lastIndexOf('_'));

        //Get the date for each task
        var tasksContent = $( this ).html().trim();
        if ("" != tasksContent)
        {
            var tasks = tasksContent.split('\n');

            for (i = 0; i < tasks.length; i++) {
                alert(tasks[i]);
                var task = JSON.parse(tasks[i]);
                alert(task.id);
            }
            //Fill the date to identify the task
        }
    });
}

addEvent(window , "load", updateCalendar());