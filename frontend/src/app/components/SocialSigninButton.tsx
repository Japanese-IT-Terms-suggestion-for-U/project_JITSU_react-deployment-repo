"use client";

import { useSearchParams } from "next/navigation";
import { ClientSafeProvider, signIn } from "next-auth/react";

type IProps = {
  providers: Record<string, ClientSafeProvider>;
};

export default function SocialSigninButton({ providers }: IProps) {
  const searchParams = useSearchParams();
  const callbackUrl = searchParams.get("callbackUrl");

  console.log(searchParams);
  console.log(callbackUrl);

  return (
    <div>
      {Object.values(providers).map((provider) => (
        <div key={provider.name} className="m-4 bg-slate-200">
          <button onClick={() => signIn(provider.id, { callbackUrl })}>
            Sign in with {provider.name}
          </button>
        </div>
      ))}
    </div>
  );
}
