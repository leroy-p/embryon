import React, { Component } from "react";
import "../../styles/forgotten-password.css";

import Title from "../Title";
import Form from "../Form";
import Button from "../Button";

class ForgottenPasswordActivity extends Component {
  render() {
    let inputs = [
      {
        name: "email",
        value: "Email",
        type: "text"
      }
    ];
    let forgottenPasswordAction = null;
    return (
      <div className="forgotten-password">
        <Title value="Embryon" />
        <h2 className="forgotten-password-title">Récupération du mot de passe</h2>
        <div className="forgotten-password-box">
          <Form inputs={inputs} />
          <Button value="Valider" action={forgottenPasswordAction}/>
        </div>
      </div>
    );
  }
}

export default ForgottenPasswordActivity;
