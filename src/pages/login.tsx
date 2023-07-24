import React, { useState } from "react";
import axios from "axios";
import GoogleLoginButton from "../components/layout/googleLoginButton";
import { GoogleLoginResponse } from "react-google-login";
import jitsu_logo from "../assets/jitsu_logo.jpeg";

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
      <div className="flex h-screen w-full items-center justify-center bg-cover bg-no-repeat">
        <div className="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-lg backdrop-blur-md max-sm:px-8">
          <div className="text-white">
            <div className="mb-8 flex flex-col items-center">
              {/* FIXME: 로고 삽입 */}
              <img src={jitsu_logo} width="150" alt="" srcSet="" />
              <h1 className="mb-2 text-2xl">JITSU</h1>
              <span className="text-gray-300">개발 단어 학습을 간편하게</span>
            </div>
            <GoogleLoginButton
              onSuccess={responseGoogleSuccess}
              onFailure={responseGoogleFailure}
            />
          </div>
        </div>
      </div>
    </>
  );
};

export default Login;
