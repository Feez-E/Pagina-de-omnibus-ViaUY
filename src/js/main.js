import React from 'react';
import ReactDOM from 'react-dom/client';
import NavBar from '../components/NavBar';

const navBar = ReactDOM.createRoot(document.getElementById('navBar'));

navBar.render(
  <React.StrictMode>
    <NavBar />
  </React.StrictMode>
);
