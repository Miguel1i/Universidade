import { styled } from "styled-components";
import Video from "../components/Video.jsx";

const Title = styled.h1`
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 64px;
  font-family: Counter-Strike;
  font-weight: 500;
  z-index: 1;
  position: relative;
`;

const SubmitButton = styled.button`
  border: none;
  margin-top: 20px;
  margin-bottom: 20px;
  background-color: white;
  font-size: 20px;
  font-family: HL2cross;
  font-weight: 400;
  padding: 10px;
  border-radius: 10px;
  z-index: 1;
  position: relative;
`;

const Paragrafo = styled.label`
  color: white;
  font-size: 30px;
  margin-bottom: 2%;
  font-weight: 500;
  word-wrap: break-word;
  z-index: 1;
  position: relative;
`;

const Anchor = styled.a`
  text-decoration: none;
  color: black;
`;

const ContainerStyled = styled.div`
  position: absolute;
  z-index: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  width: 100%;
  top: 0;
  left: 0;
`;

export default function Endscreen({ score }) {
  return (
    <>
      <Video />
      <ContainerStyled>
        <Title>Pontuação</Title>
        <Paragrafo>{score} pts.</Paragrafo>
        <SubmitButton>
          <Anchor href="/menu">Home</Anchor>
        </SubmitButton>
      </ContainerStyled>
    </>
  );
}
