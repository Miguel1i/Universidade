import DefaultLayout from "../layouts/DefaultLayout";
import { styled } from "styled-components";
import background from "../assets/images/background.jpg";
import { logout } from "../services/Auth";

const Header = styled.div`
  left: 14px;
  top: 400px;
  position: absolute;
`;

const CounterStrike = styled.span`
  color: white;
  font-size: 96px;
  font-family: Counter-Strike;
  font-weight: 500;
`;

const Quiz = styled.span`
  color: white;
  font-size: 64px;
  font-family: Counter-Strike;
  font-weight: 500;
  word-wrap: break-word;
  margin-left: 500px;
`;

const Options = styled.div`
  position: absolute;
  top: 600px;
  margin-left: 2%;
`;

const UnorderedList = styled.ul`
  list-style: none;
  color: white;
  font-size: 20px;
  font-family: HL2cross;
  font-weight: 400;
  padding: 10px;
`;

const Anchor = styled.a`
  text-decoration: none;
`;

const ListItem = styled.li`
  list-style: none;
  color: white;
  font-size: 20px;
  font-family: HL2cross;
  font-weight: 400;
  padding: 10px;
`;

export default function Menu() {
  return (
    <DefaultLayout background={background}>
      <Header>
        <CounterStrike>Counter-Strike</CounterStrike>
        <br></br>
        <Quiz>Quiz</Quiz>
      </Header>
      <Options>
        <UnorderedList>
          <Anchor href="/criar">
            <ListItem>CRIAR JOGO</ListItem>
          </Anchor>
          <Anchor href="/equipa">
            <ListItem>EQUIPA</ListItem>
          </Anchor>
          <Anchor href="/leaderboard">
            <ListItem>LEADERBOARDS</ListItem>
          </Anchor>
          <Anchor href="/login">
            <ListItem onClick={logout}>LOGOUT</ListItem>
          </Anchor>
        </UnorderedList>
      </Options>
    </DefaultLayout>
  );
}
