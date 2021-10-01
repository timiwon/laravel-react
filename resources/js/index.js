/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

import 'bootstrap/dist/css/bootstrap.min.css';
import './bootstrap';
import 'antd/dist/antd.css';
import '../css/app.css';

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import React from "react"
import ReactDOM from "react-dom"
import { Provider } from "react-redux"
import { store } from "./stores"

import App from './App';
// <React.StrictMode>
ReactDOM.render(
  <React.Fragment>
    <Provider store={store}>
        <App />
    </Provider>
  </React.Fragment>,
  document.getElementById("root")
)
