import React, { useState } from "react";
import axios from "axios";
import GoogleLoginButton from "../components/layout/googleLoginButton";
import { GoogleLoginResponse } from "react-google-login";

const Login: React.FC = () => {
  const responseGoogleSuccess = (response: GoogleLoginResponse) => {
    const tokenId = response.tokenId;

    axios
      .post("http://127.0.0.1:8000/login", { tokenId: tokenId })
      .then((res) => {
        console.log(res.data);
        localStorage.setItem("accessToken", res.data.access_token);
        localStorage.setItem("userId", res.data.user_id.toString());
      })
      .catch((error) => {
        console.error(error);
      });
  };

  const responseGoogleFailure = (error: any) => {
    console.error("Google Login Failed: ", error);
  };

  return (
    <>
      <GoogleLoginButton
        onSuccess={responseGoogleSuccess}
        onFailure={responseGoogleFailure}
      />
    </>
  );
};

export default Login;
