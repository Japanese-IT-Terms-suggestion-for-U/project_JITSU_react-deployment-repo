import { Suspense } from "react";
import Header from "./Header";
import Footer from "./Footer";
import "./globals.css";
import type { Metadata } from "next";
import Loading from "./loading";
import AuthSession from "./components/Sign/AuthSession";

export const metadata: Metadata = {
  title: "JITSU",
  description: "JITSU Application",
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="ja">
      <body className="container mx-auto sm:p-4 bg-slate-700 text-slate-50 flex justify-center items-center">
        <AuthSession>
          <div className="flex flex-col min-h-screen">
            <Header />
            <main className="flex-grow">
              <Suspense fallback={<Loading />}>{children}</Suspense>
            </main>
            <Footer />
          </div>
        </AuthSession>
      </body>
    </html>
  );
}
