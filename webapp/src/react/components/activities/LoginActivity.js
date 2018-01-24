import React, { Component } from 'react';
import '../../styles/login.css';

import Title from '../Title';
import Form from '../Form';
import Button from '../Button';

class LoginActivity extends Component {
  render() {
    let forgotten = "Mot de passe oublié ?";
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
      }
    ];
    let loginAction = () => window.location = "/home";
    let signupAction = () => window.location = "/signup";

    return (
      <div className="login">
        <Title value="Embryon" />
        <div className="login-box">
          <Form inputs={inputs} />
          <Button value="Se connecter" action={loginAction}/>
          <Button value="S'inscrire" action={signupAction}/>
          <a className="forgotten-link" href="/forgotten-password">{forgotten}</a>
        </div>
      </div>
    );
  }
}

export default LoginActivity;
