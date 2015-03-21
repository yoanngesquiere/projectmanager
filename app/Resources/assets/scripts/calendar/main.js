var $ = jQuery =  require("jquery");

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
    // Initialize columnsData from calendar
    var columns = $(".week_calendar_header");
    var columnsData = new Array();
    for (j = 0; j < columns.length; j++) {
        var columnClass = columns[j].className.trim();
        // Some columns must not be checked because they must not be used to display tasks
        var displayColumn = true;
        for (var index=0; index<excludeColumnCriteria.length; index++) {
            if (columnClass.indexOf(excludeColumnCriteria[index]) > -1) {
                displayColumn = false;
            }
        }
        if(!displayColumn) {
            continue;
        }

        // Get the day associated to the current column
        var startDayClass = columnClass.indexOf(columnClassPrefix);
        var endDayClass = columnClass.indexOf(" ", columnClass.indexOf(columnClassPrefix));
        if (endDayClass < startDayClass) {
            endDayClass = columnClass.length;
        }
        var dayClass = columnClass.substring(startDayClass, endDayClass);
        var columnDay = dayClass.substring(columnClassPrefix.length);
        columnsData[columnDay] = columns[j].id.substring(6);
    }

    // Process each user's line
    $( "."+checkedElementsClass ).each(function(  ) {
        // Get user information
        var elementId = $( this ).attr('id');
        var userId = elementId.substring(elementId.indexOf('_')+1, elementId.lastIndexOf('_'));
        var tasksContent = $( this ).html().trim();
        // Triggers the process only when the user has at least one task for the current calendar
        if ("" != tasksContent) {
            var tasks = tasksContent.split('\n');
            var currentTask = null;
            var process = false;
            for (i = 0; i < tasks.length; i++) {
                // Manage JSON entities on multiple lines
                if (tasks[i].indexOf("{")>=0 && tasks[i].indexOf("}")>=0) {
                    currentTask = tasks[i];
                    process = true;
                } else if (tasks[i].indexOf("{")>=0) {
                    currentTask = tasks[i];
                } else if (tasks[i].indexOf("}")>=0) {
                    currentTask += tasks[i];
                    process = true;
                } else {
                    currentTask += tasks[i];
                }

                // When the JSON string is complete, we can use it as an object
                if (process) {
                    var task = JSON.parse(currentTask);
                    for (j = 0; j < columnsData.length; j++) {
                        if (task.start <= columnsData[j] && task.end >= columnsData[j]) {
                            var td = "tr#user_row_" + userId + " td." + columnClassPrefix + j;
                            var taskLink = "<a href=\""+task.link+"\">"+task.name+"</a>";
                            if ($(td).html().trim() != '') {
                                taskLink = "<br />"+taskLink;
                            }
                            $(td).html($(td).html() + taskLink);
                        }
                    }
                    process = false;
                }
            }
        }
    });
}

var excludeColumnsWithClass = ['calendar_users', 'non_working_day'];
addEvent(window , "load", updateCalendar("user_tasks", excludeColumnsWithClass, "day_"));
