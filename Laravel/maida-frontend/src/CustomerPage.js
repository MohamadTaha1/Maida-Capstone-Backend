// src/CustomerPage.js

import React from 'react';

const CustomerPage = ({ user }) => {
  return (
    <div>
      <h1>Welcome to the Customer Dashboard</h1>
      <p>Hello, {user.name}! We are glad to see you back.</p>
    </div>
  );
};

export default CustomerPage;
