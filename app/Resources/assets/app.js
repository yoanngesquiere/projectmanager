var $ = jQuery =  require("jquery"),
    React = require('react'),
    bootstrap = require('bootstrap');
var test = require('./scripts/calendar/main');

var DeletionConfirmationPopIn = React.createClass({
    render: function() {
        return (
            <div className="DeletionConfirmationPopIn">
        Hello, world! I am a CommentBox.
        </div>
        );
    }
});

var docs = document.getElementsByClassName('DeletionConfirmationPopInDiv');
for (var i=0, max=docs.length; i < max; i++) {
    React.render(
        <DeletionConfirmationPopIn />,
        docs[i]
    );
}