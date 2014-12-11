function addEvent(obj, event, fct) {
    if (obj.attachEvent) //Est-ce IE ?
        obj.attachEvent("on" + event, fct); //Ne pas oublier le "on"
    else
        obj.addEventListener(event, fct, true);
}

function updateCalendar(){

}

addEvent(window , "load", updateCalendar());