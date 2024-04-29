import React from 'react';

const ResetPassword = () => {
  return (
    <div className="container mt-5">
      <h2>Reset Password</h2>
      <form>
        <div className="mb-3">
          <label htmlFor="password" className="form-label">New Password</label>
          <input type="password" className="form-control" id="password" />
        </div>
        <div className="mb-3">
          <label htmlFor="password_confirmation" className="form-label">Confirm New Password</label>
          <input type="password" className="form-control" id="password_confirmation" />
        </div>
        <button type="submit" className="btn btn-primary">Reset Password</button>
      </form>
    </div>
  );
}

export default ResetPassword;
