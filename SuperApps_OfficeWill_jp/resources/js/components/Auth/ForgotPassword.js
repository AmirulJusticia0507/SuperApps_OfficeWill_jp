import React from 'react';

const ForgotPassword = () => {
  return (
    <div className="container mt-5">
      <h2>Forgot Password</h2>
      <form>
        <div className="mb-3">
          <label htmlFor="email" className="form-label">Email address</label>
          <input type="email" className="form-control" id="email" />
        </div>
        <button type="submit" className="btn btn-primary">Send Reset Link</button>
      </form>
    </div>
  );
}

export default ForgotPassword;
