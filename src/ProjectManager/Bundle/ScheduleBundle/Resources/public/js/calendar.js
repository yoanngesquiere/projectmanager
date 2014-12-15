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
            var columns = $(".week_calendar_header");
            var columnsData = new Array();
            for (j = 0; j < columns.length; j++) {
                var line = (columns[j].classList);
                //Don't use the users' column
                if(line.contains("calendar_users"))
                {
                    continue;
                }
                var columnDate = columns[j].id.substring(6);
                var whereIsDay = columns[j].className.indexOf("day_")
                var columnDay = columns[j].className.substring(whereIsDay + 4, whereIsDay + 5);
                columnsData[columnDay] = columnDate;
            }

            var tasks = tasksContent.split('\n');

            for (i = 0; i < tasks.length; i++) {
                var task = JSON.parse(tasks[i]);
                for (j = 0; j < columnsData.length; j++) {
                    if (task.start <= columnsData[j] && task.end >= columnsData[j]) {
                        var td = "tr#user_row_"+userId+ " td.day_"+j;
                        $(td).html($(td).html()+task.name);
                    }
                }
            }
        }
    });
}

addEvent(window , "load", updateCalendar());
