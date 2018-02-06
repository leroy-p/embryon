import React, { Component } from "react";
import "../styles/navbar.css";

class Navbar extends Component {
  render() {
    return (
      <div className="navbar-component">
        <div className="navbar-left">
          <a className="logo" href="/">E</a>
        </div>
        <div className="navbar-right">
        </div>
      </div>
    );
  }
}

export default Navbar;
