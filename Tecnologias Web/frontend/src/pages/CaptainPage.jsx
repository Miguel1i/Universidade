import arrow from "../assets/images/arrow.png";
import Video from "../components/Video.jsx";
import { ContainerStyled } from "../components/ContainerStyled";
import { Title } from "../components/Title";
import { useState, useEffect, useContext } from "react";
import {
  getTeam,
  getTeamPlayers,
  invitePlayer,
  removePlayer,
} from "../services/Team";
import { AuthContext } from "../Context";
import { Formik } from "formik";
import * as Yup from "yup";
import {
  Input,
  InputErrorLabel,
  SubmitButton,
  InputContainer,
} from "../components/Form.jsx";

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

  async function expulsePlayer(username) {
    try {
      await removePlayer(username);
      // Refresh players list after removal
      const updatedPlayers = players.filter(
        (player) => player.username !== username
      );
      setPlayers(updatedPlayers);
    } catch (error) {
      console.error("Error expelling player:", error);
    }
  }

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
                <td>
                  {player.username !== teamRecord[0].captain && (
                    <input
                      type="button"
                      onClick={() => expulsePlayer(player.username)}
                      value="-"
                    />
                  )}
                </td>
              </tr>
            ))}
          </tbody>
        </table>

        <Formik
          initialValues={{ username: "" }}
          validationSchema={Yup.object({
            username: Yup.string().required("Username is required"),
          })}
          onSubmit={async (values, { setSubmitting, resetForm }) => {
            setSubmitting(true);
            try {
              await invitePlayer(teamRecord[0].teamId, values.username);
              resetForm();
            } catch (error) {
              console.error("Error inviting player:", error);
            } finally {
              setSubmitting(false);
            }
          }}
        >
          {({
            values,
            errors,
            touched,
            handleChange,
            handleBlur,
            handleSubmit,
            isSubmitting,
          }) => (
            <form onSubmit={handleSubmit}>
              <InputContainer
                style={{ display: "inline-block", padding: "10px 20px" }}
              >
                <Input
                  type="text"
                  placeholder="Username"
                  name="username"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.username}
                  style={{ borderRadius: "5px" }}
                />
                <InputErrorLabel>
                  {errors.username && touched.username && errors.username}
                </InputErrorLabel>
              </InputContainer>
              <SubmitButton
                type="submit"
                disabled={isSubmitting}
                style={{
                  display: "inline-block",
                  padding: "10px 20px",
                  borderRadius: "5px",
                }}
              >
                Invite Player
              </SubmitButton>
            </form>
          )}
        </Formik>
      </ContainerStyled>
    </>
  );
}
