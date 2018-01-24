import React, { Component } from 'react';
import PropTypes from 'prop-types';
import '../styles/title.css';

class Title extends Component {
  render() {
    return (
      <div className="title-component">
        <h1><a className="title" href="/login">{this.props.value.toUpperCase()}</a></h1>
        <div className="separator1"></div>
        <div className="separator2"></div>
      </div>
    );
  }
}

Title.propTypes = {
  value: PropTypes.string.isRequired
}

export default Title;
