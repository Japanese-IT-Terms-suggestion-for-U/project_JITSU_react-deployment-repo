import React from "react";
import { GoogleLogin, GoogleLoginResponse } from "react-google-login";

interface GoogleButtonProps {
  onSuccess: (response: GoogleLoginResponse) => void;
  onFailure: (error: any) => void;
}

const GoogleLoginButton: React.FC<GoogleButtonProps> = ({
  onSuccess,
  onFailure,
}) => {
  const clientId = process.env.REACT_APP_GOOGLE_CLIENT_ID || "";

  return (
    <>
      <GoogleLogin
        clientId={clientId}
        buttonText="Login with Google"
        onSuccess={onSuccess as any}
        onFailure={onFailure}
        cookiePolicy={"single_host_origin"}
      />
    </>
  );
};

export default GoogleLoginButton;
