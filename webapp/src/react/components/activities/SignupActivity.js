import React, { Component } from "react";
import axios from "axios";
import "../../styles/signup.css";

import Popup from "../Popup";
import Title from "../Title";
import Form from "../Form";
import Button from "../Button";

class SignupActivity extends Component {
  constructor(props) {
    super(props);
    this.state = {
      email: "",
      password: "",
      confirmation: "",
      popupTitle: "",
      popupMessage: "",
      popupDestination: null
    };
    this.setEmail = this.setEmail.bind(this);
    this.setPassword = this.setPassword.bind(this);
    this.setConfirmation = this.setConfirmation.bind(this);
    this.signupAction = this.signupAction.bind(this);
  }

  translateMessage(message) {
    switch (message) {
      case "Email required." :
        return "Email requis.";
      case "Password required." :
        return "Mot de passe requis.";
      case "Confirmation required." :
        return "Confirmation requise.";
      case "Invalid email." :
        return "Email invalide.";
      case "Invalid password." :
        return "Mot de passe invalide.";
      case "Password and confirmation are different." :
        return "Le mot de passe et la confirmation sont différents.";
      case "Email already taken." :
        return "Email déjà enregistré.";
      case "User created." :
        return "Utilisateur créé."
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

  setConfirmation(event) {
    this.setState({ confirmation: event.target.value });
  }

  signupAction() {
    axios.post("http://localhost/embryon/api/actions/user/add", {
      email: this.state.email,
      password: this.state.password,
      confirmation: this.state.confirmation,
    })
    .then(response => {
      let popup = document.getElementsByClassName("popup-component")[0];
      popup.style.opacity = 1;
      popup.style.pointerEvents = "auto";
      if (response.data.id > 0) {
        this.setState({ popupTitle: "Succès :", popupMessage: this.translateMessage(response.data.message), popupDestination: "/login" });
      } else {
        this.setState({ popupTitle: "Erreur :", popupMessage: this.translateMessage(response.data.message) });
      }
    })
    .catch(error => {
      console.log(error);
    });
  }

  render() {
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
      },
      {
        name: "confirmation",
        value: "Confirmation",
        type: "password",
        action: this.setConfirmation
      }
    ];

    return (
      <div className="signup">
        <Popup title={this.state.popupTitle} message={this.state.popupMessage} destination={this.state.popupDestination} />
        <Title value="Embryon" />
        <h2 className="signup-title">Inscription</h2>
        <div className="signup-box">
          <Form inputs={inputs} />
          <Button value="S'inscrire" action={this.signupAction}/>
        </div>
      </div>
    );
  }
}

export default SignupActivity;
