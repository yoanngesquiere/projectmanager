(function() {
    'use strict';

    var React = require('react');
    var _ = require('lodash');

    module.exports = React.createClass({
        getDefaultProps: function() {
            return {
                originalSelection: new Array(),
                availableValues: new Array(),
                objectId: 0,
                saveMethod: function(){}
            };
         },

        getInitialState: function() {
            var selection = new Array();
            for (var i=0, max=this.props.originalSelection.length; i < max; i++) {
                selection.push(this.props.originalSelection[i]);
            }

            return {
                currentSelection: selection
            };
        },

        changeSelection: function(id) {
            var selection = this.state.currentSelection;
            if (_.contains(selection, id)) {
                _.pull(selection, id);
            } else {
                selection.push(id);
            }
            this.setState({currentSelection: selection});
        },

        handleSaveClick: function(event) {
            this.props.saveMethod(
                this.props.objectId,
                this.state.currentSelection
            );
            this.handleCancelClick(event);
        },

        handleCancelClick: function(event) {
            React.unmountComponentAtNode(this.getDOMNode().parentNode);
        },

        render: function() {
            var options = this.props.availableValues.map(function(opt, i){
                var checked = false;
                if (_.contains(this.state.currentSelection, opt.id)) {
                    checked = true;
                }

                return(
                    <span key={opt.id}>
                        <input type="checkbox" data-id={opt.id} value={opt.id} checked={checked} onChange={this.changeSelection.bind(this, opt.id)} />{opt.name}
                    </span>
                );
            }, this);

            return(
                <div>
                    {options}
                    <button onClick={this.handleSaveClick}>Save</button>
                    <button onClick={this.handleCancelClick}>Cancel</button>
                </div>
            );
        }
    });
})();
