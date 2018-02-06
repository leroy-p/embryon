import React, { Component } from "react";
import PropTypes from "prop-types";
import "../styles/popup.css";

import Button from "./Button.js";

class Popup extends Component {
  constructor(props) {
    super(props);
    this.onButtonClick = this.onButtonClick.bind(this);
  }

  onButtonClick() {
      let popup = document.getElementsByClassName("popup-component")[0];
      popup.style.opacity = 0;
      popup.style.pointerEvents = "none";
      if (this.props.destination) {
        window.location = this.props.destination;
      }
  }

  render() {
    return (
      <div className="popup-component">
        <div className="popup">
          <p className="popup-title">{this.props.title}</p>
          <p className="popup-message">{this.props.message}</p>
          <div className="popup-button">
            <Button value="OK" action={this.onButtonClick} />
          </div>
        </div>
      </div>
    );
  }
}

Popup.propTypes = {
  title: PropTypes.string,
  message: PropTypes.string,
  destination: PropTypes.string
}

export default Popup;
