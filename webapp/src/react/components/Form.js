import React, { Component } from 'react';
import PropTypes from 'prop-types';
import '../styles/form.css';

class Form extends Component {
  render() {
    return (
      <form className="form-component">
        {this.props.inputs.map((input, index) => {
          return (
            <div key={index} className="input-container">
              {input.value}<br />
              <input className="form-component-input"name={input.name} type={input.type} />
            </div>
          );
        })}
      </form>
    );
  }
}

Form.propTypes = {
  inputs: PropTypes.array.isRequired
}

export default Form;
