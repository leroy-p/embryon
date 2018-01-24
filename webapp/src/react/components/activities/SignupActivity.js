import React, { Component } from 'react';
import '../../styles/signup.css';

import Title from '../Title';
import Form from '../Form';
import Button from '../Button';

class SignupActivity extends Component {
  render() {
    let inputs = [
      {
        name: "email",
        value: "Email",
        type: "text"
      },
      {
        name: "password",
        value: "Mot de passe",
        type: "password"
      },
      {
        name: "confirmation",
        value: "Confirmation",
        type: "password"
      }
    ];
    let signupAction = null;
    return (
      <div className="signup">
        <Title value="Embryon" />
        <h2 className="signup-title">Inscription</h2>
        <div className="signup-box">
          <Form inputs={inputs} />
          <Button value="S'inscrire" action={signupAction}/>
        </div>
      </div>
    );
  }
}

export default SignupActivity;
