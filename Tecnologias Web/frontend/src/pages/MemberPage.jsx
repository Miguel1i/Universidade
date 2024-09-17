import arrow from "../assets/images/arrow.png";
import Video from "../components/Video.jsx";
import { ContainerStyled } from "../components/ContainerStyled";
import { Title } from "../components/Title";
import { useState, useEffect, useContext } from "react";
import { getTeam, getTeamPlayers } from "../services/Team";
import { AuthContext } from "../Context";

export default function CaptainPage() {
  const [teamRecord, setTeamRecord] = useState([]);
  const { user } = useContext(AuthContext);
  const [players, setPlayers] = useState([]);
  const [currentPage, setCurrentPage] = useState(1);
  const recordsPerPage = 5;

  useEffect(() => {
    const fetchTeam = async () => {
      try {
        const data = await getTeam(user?.username);
        setTeamRecord(data);
      } catch (error) {
        console.error("Error fetching team data:", error);
      }
    };
    if (user?.username) {
      fetchTeam();
    }
  }, [user?.username]);

  useEffect(() => {
    const fetchTeamPlayers = async () => {
      try {
        if (teamRecord.length > 0) {
          const data = await getTeamPlayers(teamRecord[0].teamId);
          setPlayers(data);
        }
      } catch (error) {
        console.error("Error fetching team players:", error);
      }
    };
    fetchTeamPlayers();
  }, [teamRecord]);

  const lastIndex = currentPage * recordsPerPage;
  const firstIndex = lastIndex - recordsPerPage;
  const currentRecords = players.slice(firstIndex, lastIndex);

  return (
    <>
      <Video />
      <ContainerStyled>
        <a href="/menu" style={{ marginLeft: "-93%", marginTop: "-6%" }}>
          <img
            src={arrow}
            style={{ width: "46px", height: "46px" }}
            alt="arrow"
          />
        </a>
        <Title>
          {teamRecord.length > 0 ? teamRecord[0].teamName : "Loading..."}
        </Title>
        <table
          className="table"
          style={{ borderSpacing: 20, fontSize: 30, textAlign: "center" }}
        >
          <thead>
            <tr>
              <th>Nome</th>
              <th>Role</th>
            </tr>
          </thead>
          <tbody>
            {currentRecords.map((player, i) => (
              <tr key={i}>
                <td>{player.username}</td>
                <td>
                  {player.username === teamRecord[0].captain
                    ? "Captain"
                    : "Member"}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </ContainerStyled>
    </>
  );
}
