import React, { Component } from 'react';
import {
  BrowserRouter as Router,
  Route
} from 'react-router-dom'
import './react/styles/app.css';

import LoginActivity from './react/components/activities/LoginActivity'
import HomeActivity from './react/components/activities/HomeActivity'
import SignupActivity from './react/components/activities/SignupActivity'
import ForgottenPasswordActivity from './react/components/activities/ForgottenPasswordActivity'

class App extends Component {
  render() {
    return (
      <Router>
        <div>
          <Route exact path="/" component={HomeActivity} />
          <Route path="/login" component={LoginActivity} />
          <Route path="/signup" component={SignupActivity} />
          <Route path="/forgotten-password" component={ForgottenPasswordActivity} />
        </div>
      </Router>
    );
  }
}

export default App;
