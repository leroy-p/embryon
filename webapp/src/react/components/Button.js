import React, { Component } from "react";
import PropTypes from "prop-types";
import "../styles/button.css";

class Button extends Component {
  render() {
    return (
      <div className="button-component" onClick={this.props.action}>
        {this.props.value}
      </div>
    );
  }
}

Button.propTypes = {
  value: PropTypes.string.isRequired,
  action: PropTypes.func
}

export default Button;
