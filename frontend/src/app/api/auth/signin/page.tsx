import { ClientSafeProvider, getProviders, signIn } from "next-auth/react";
import { getServerSession } from "next-auth/next";
import { authOptions } from "../[...nextauth]/route";
import SocialSigninButton from "../../../components/Sign/SocialSigninButton";

type IProps = {
  providers: Record<string, ClientSafeProvider>;
};

export default async function SignInPage() {
  const session = await getServerSession(authOptions);
  if (session) {
    return { redirect: { destination: "/" } };
  }

  const providers = await getProviders();

  return (
    <>
      <h1 className="text-3xl font-bold">로그인 페이지</h1>
      <div className="m-4">
        <SocialSigninButton providers={providers} />
      </div>
    </>
  );
}
