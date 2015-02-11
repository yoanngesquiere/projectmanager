(function () {
    'use strict';

    var React = require('react');

    module.exports = React.createClass({
        handleClick: function(event) {
            this.props.form.submit();
        },
        render: function() {
            return (
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 className="modal-title">Confirm deletion</h4>
                        </div>
                        <div className="modal-body">
                            <p>Are you sure you want to delete {this.props.name}&#63;</p>
                        </div>
                        <div className="modal-footer">
                            <button type="button" className="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" className="btn btn-primary" onClick={this.handleClick}>Delete</button>
                        </div>
                    </div>
                </div>
            );
        }
    });

})();
