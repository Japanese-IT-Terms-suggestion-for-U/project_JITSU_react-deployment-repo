import Link from "next/link";
import React from "react";

const Footer = () => {
  return (
    <footer className="py-2 px-4 border-t">
      <Link href="https://github.com/yuminn-k">
        <small>@2023 yuminn-k</small>
      </Link>
    </footer>
  );
};

export default Footer;
