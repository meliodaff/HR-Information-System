import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css'; 
import Homepage from './pages/Homepage';
import JobOffer from './pages/Joboffer';
import Dashboard from './pages/Dashboard';

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <Homepage />
  </React.StrictMode>
);