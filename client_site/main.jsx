import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import './index.css';
import {BrowserRouter} from 'react-router-dom';


/*
  TO-DO:
  1. Import BrowserRouter from react-router-dom
  
  2. Wrap App in BrowserRouter
*/

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <BrowserRouter>
      <App />
    </BrowserRouter>
  </React.StrictMode>
);