import React, { Component } from "react";
import axios from "axios";
import "../../styles/login.css";

import Popup from "../Popup";
import Title from "../Title";
import Form from "../Form";
import Button from "../Button";

class LoginActivity extends Component {
  constructor(props) {
    super(props);
    this.state = {
      email: "",
      password: "",
      popupTitle: "",
      popupMessage: ""
    };
    this.setEmail = this.setEmail.bind(this);
    this.setPassword = this.setPassword.bind(this);
    this.loginAction = this.loginAction.bind(this);
  }

  translateMessage(message) {
    switch (message) {
      case "Email required." :
        return "Email requis.";
      case "Password required." :
        return "Mot de passe requis.";
      case "Incorrect email or password." :
        return "Email ou mot de passe incorrect.";
      default:
        return null;
    }
  }

  setEmail(event) {
    this.setState({ email: event.target.value });
  }

  setPassword(event) {
    this.setState({ password: event.target.value });
  }

  loginAction() {
    axios.post("http://localhost/embryon/api/actions/user/login", {
      email: this.state.email,
      password: this.state.password
    })
    .then(response => {
      if (response.data.id > 0) {
          window.location = "/";
      } else {
        this.setState({ popupTitle: "Erreur :", popupMessage: this.translateMessage(response.data.message) });
        let popup = document.getElementsByClassName("popup-component")[0];
        popup.style.opacity = 1;
        popup.style.pointerEvents = "auto";
      }
    })
    .catch(error => {
      console.log(error);
    });
  }

  signupAction() {
    window.location = "/signup";
  }

  render() {
    let forgotten = "Mot de passe oublié ?";
    let inputs = [
      {
        name: "email",
        value: "Email",
        type: "text",
        action: this.setEmail
      },
      {
        name: "password",
        value: "Mot de passe",
        type: "password",
        action: this.setPassword
      }
    ];

    return (
      <div className="login">
        <Popup title={this.state.popupTitle} message={this.state.popupMessage} destination={null}/>
        <Title value="Embryon" />
        <div className="login-box">
          <Form inputs={inputs} />
          <Button value="Se connecter" action={this.loginAction}/>
          <Button value="S'inscrire" action={this.signupAction}/>
          <a className="forgotten-link" href="/forgotten-password">{forgotten}</a>
        </div>
      </div>
    );
  }
}

export default LoginActivity;
