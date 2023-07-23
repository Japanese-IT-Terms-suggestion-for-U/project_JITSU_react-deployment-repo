import type { IProps } from "../../types/common.interface";
import { BrowserRouter as Router } from "react-router-dom";
import Body from "./body";
import Header from "./header";

const Layout = ({ children }: IProps) => {
  return (
    <Router>
      <Header />
      <Body>{children}</Body>
    </Router>
  );
};

export default Layout;
