"use client";

import { signIn, signOut, useSession } from "next-auth/react";
import Image from "next/image";
import React from "react";
import styled from "styled-components";

const Container = styled.div`
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5rem;
  background-color: #1e293b;
`;

const LogoLink = styled.a`
  color: #0284c7;

  &:hover {
    color: #0470dc;
    transition-duration: 0.2s;
    transition-timing-function: ease-in-out;
    transition-property: all;
  }
`;

const AppBar = () => {
  const { data: session } = useSession();

  return (
    <Container>
      <div />
      <LogoLink href="/">
        <Image src="/jitsu_logo.png" alt="Logo" width={50} height={50} />
      </LogoLink>
      <div>
        {session?.user ? (
          <>
            {/* FIXME: 헤더 완성 후 제거 */}
            {/* <span className="text-sky-600"> {session.user.email}</span> */}
            <button className="text-red-500" onClick={() => signOut()}>
              로그아웃
            </button>
          </>
        ) : (
          <button className="text-green-600" onClick={() => signIn()}>
            로그인
          </button>
        )}
      </div>
    </Container>
  );
};

export default AppBar;
