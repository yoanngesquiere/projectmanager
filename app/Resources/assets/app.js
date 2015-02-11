var $ = jQuery =  require("jquery"),
    React = require('react'),
    bootstrap = require('bootstrap');
var calendarScript = require('./scripts/calendar/main');
var modal = require('./scripts/components/modal')

deleteBtns = document.getElementsByClassName('delete-btn');
for (var i=0, max=deleteBtns.length; i < max; i++) {
    deleteBtns[i].onclick=function(){
        var deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            React.render(React.createElement(modal, {'name': this.getAttribute("entity_name"), 'form':this.form}), deleteModal);
        }
    };
}


