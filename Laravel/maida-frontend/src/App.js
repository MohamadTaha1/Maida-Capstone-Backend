// src/App.js
import React, { useState } from 'react';
import LoginPage from './LoginPage';
import CustomerPage from './CustomerPage';
import ChefPage from './ChefPage';
import DeliveryPage from './DeliveryPage';
import { Routes, Route, Navigate } from 'react-router-dom';

const App = () => {
  const [user, setUser] = useState(null);

  // Simulate a login function that sets the user state
  const handleLogin = (userInfo) => {
    setUser(userInfo);
  };

  return (
    <div className="App">
      <Routes>
        <Route path="/login" element={!user ? <LoginPage onLogin={handleLogin} /> : <Navigate replace to={`/${user.role}`} />} />
        <Route path="/customer" element={user?.role === 'customer' ? <CustomerPage user={user} /> : <Navigate replace to="/login" />} />
        <Route path="/chef" element={user?.role === 'chef' ? <ChefPage user={user} /> : <Navigate replace to="/login" />} />
        <Route path="/delivery" element={user?.role === 'delivery' ? <DeliveryPage user={user} /> : <Navigate replace to="/login" />} />
        <Route path="*" element={<Navigate replace to="/login" />} />
      </Routes>
    </div>
  );
};

export default App;
