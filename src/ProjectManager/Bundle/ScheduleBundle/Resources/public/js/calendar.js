function addEvent(obj, event, fct) {
    if (obj.attachEvent)
        obj.attachEvent("on" + event, fct);
    else
        obj.addEventListener(event, fct, true);
}
/**
 * Function used to fill the calendar with the tasks assigned to the displayed users
 */
function updateCalendar(checkedElementsClass, excludeColumnCriteria, columnClassPrefix) {
    //Initialize columnsData from calendar
    var columns = $(".week_calendar_header");
    var columnsData = new Array();
    for (j = 0; j < columns.length; j++) {
        var columnClass = columns[j].className.trim();
        //Some columns must not be checked because it is not part of the calendar itself
        if(columnClass.indexOf(excludeColumnCriteria) > 0) {
            continue;
        }
        var startDayClass = columnClass.indexOf(columnClassPrefix);
        var endDayClass = columnClass.indexOf(" ", columnClass.indexOf(columnClassPrefix));
        if (endDayClass < startDayClass) {
            endDayClass = columnClass.length
        }
        var dayClass = columnClass.substring(startDayClass, endDayClass);
        var columnDay = dayClass.substring(columnClassPrefix.length);
        columnsData[columnDay] = columns[j].id.substring(6);
    }

    //Process each user's line
    $( "."+checkedElementsClass ).each(function(  ) {
        //Get user information
        var elementId = $( this ).attr('id');
        var userId = elementId.substring(elementId.indexOf('_')+1, elementId.lastIndexOf('_'));
        var tasksContent = $( this ).html().trim();
        //Triggers the process only when the user has at least one task for the current calendar
        if ("" != tasksContent) {
            var tasks = tasksContent.split('\n');
            for (i = 0; i < tasks.length; i++) {
                var task = JSON.parse(tasks[i]);
                for (j = 0; j < columnsData.length; j++) {
                    if (task.start <= columnsData[j] && task.end >= columnsData[j]) {
                        var td = "tr#user_row_"+userId+ " td."+columnClassPrefix+j;
                        $(td).html($(td).html()+task.name);
                    }
                }
            }
        }
    });
}

addEvent(window , "load", updateCalendar("user_tasks", "calendar_users", "day_"));
