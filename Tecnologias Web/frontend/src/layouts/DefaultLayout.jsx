import { styled } from "styled-components";
import defaultBackground from "../assets/images/background.jpg";
import GlobalStyle from "./globalStyle";

const Container = styled.div`
  background-image: url(${(props) => props.background || defaultBackground});
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
  min-height: 100vh;
`;

export default function DefaultLayout({ children, background }) {
  return (
    <>
      <GlobalStyle/>
      <Container background={background}>{children}</Container>
    </>
 );
}
