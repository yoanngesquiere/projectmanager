var $ = jQuery =  require("jquery"),
    React = require('react'),
    bootstrap = require('bootstrap');
require('./scripts/calendar/main');
var modal = require('./scripts/components/modal'),
    choice = require('./scripts/components/choiceSelector');
var _ = require('lodash');

var homepage = document.getElementById('homepage').textContent;

/*
 * On every list, it is possible to delete items. A modal is shown to confirm the deletion
 */
deleteBtns = document.getElementsByClassName('delete-btn');
for (var i=0, max=deleteBtns.length; i < max; i++) {
    deleteBtns[i].onclick = function() {
        var deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            React.render(React.createElement(modal, {'name': this.getAttribute("entity_name"), 'form':this.form}), deleteModal);
        }
    };
}

/* *********************************************************************************************************************
 * TEAM MEMBERS MANAGEMENT
 */

/**
 * Calls the BO to save the chosen roles for the user in the current team
 *
 * @param int   userId user id
 * @param array roles  list of roles
 *
 * @return void
 */
var saveTeamMemberRoles = function(userId, roles) {
    var updateGUI = function(data) {
        _.forEach(data, function(n, key) {
            if (n === -1) {
                var span = document.getElementById('roles_column_' + userId + '_' + key);
                span.parentNode.removeChild(span);
            } else if (n !== 0) {
                var parentElement = document.getElementById('roles_column_user_' + userId);
                var line = '<span  id="roles_column_' + userId + '_' + key + '">' + n + '</span> ';
                parentElement.innerHTML = parentElement.innerHTML + line;
            }
        });
    }

    var saveRoles = function() {
        //Serialize the data
        var queryString = "";
        _.forEach(roles, function(n) {
            queryString += "roles[]=" + n;
            //Append an & except after the last element
            if(n !== _.last(roles)) {
                queryString += "&";
            }
        });

        var teamId = document.getElementsByClassName('members_team')[0].getAttribute('name').substring('members_team_'.length);
        var url = homepage+'teammember/'+teamId+'/'+userId+'/update_roles/';
        //Save the user and its roles
        var request = new XMLHttpRequest();
        request.open('PUT', url, true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        request.send(queryString);

        request.onload = function() {
            if (request.status >= 200 && request.status < 400) {
                // Success!
                var data = JSON.parse(request.responseText);
                updateGUI(data);
            } else {
                // We reached our target server,but it returned an error
                alert('Error during roles saving');
            }
        };
    }

    saveRoles();
}

/**
 * allRoles is used on the team member page (route pm_user_team_edit)
 * It is used to fill the role list when the user wants to edit the roles of a user in a team
 *
 * @type {Array}
 */
var allRoles = new Array();
/*
 * allRoles filling
 */
$('role').each(function() {
    var role = {id: $(this).attr('id'),name: $(this).text()}
    allRoles.push(role);
});

/*
 * On the team member page (route pm_user_team_edit), it is possible to change the roles of a user in the current team.
 * This action is performed when the user clicks on the button with the updateMembers class
 */
$('.update_members').each(function() {
    $(this).click(function() {
        // Gets all the current roles for the user
        var currentUserId = $(this).attr('id').substring('update_member'.length);
        var userRoles = $('.roles_column.user'+currentUserId+' span');
        var currentsRoles = new Array();
        userRoles.each(function() {
            var id = $(this).attr('id').substring('roles_column_'.length + currentUserId.length + 1)
            currentsRoles.push(id);
        });

        // Displays the update form
        React.render(
            React.createElement(
                choice,
                {
                    'availableValues': allRoles, 'originalSelection': currentsRoles,
                    'objectId': currentUserId, 'saveMethod': saveTeamMemberRoles
                }
            ),
            $('#roles_selector_'+currentUserId)[ 0 ]);
    });
});
/*
 * TEAM MEMBERS MANAGEMENT
 **********************************************************************************************************************/
