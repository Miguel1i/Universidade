import axios from "axios";

export async function createTeam(teamName, captain) {
  const response = await axios.post(
    `${process.env.REACT_APP_API_URL}/team`,
    { teamName, captain },
    { withCredentials: true }
  );
  if (response.status === 200) {
    return response.data;
  }
}

export async function getTeam(username) {
  const response = await axios.get(
    `${process.env.REACT_APP_API_URL}/player/team`,
    {
      params: { username },
      withCredentials: true,
    }
  );
  if (response.status === 200) {
    return response.data;
  }
}

export async function getTeamPlayers(teamId) {
  const response = await axios.get(
    `${process.env.REACT_APP_API_URL}/team/players`,
    {
      params: { teamId },
      withCredentials: true,
    }
  );
  if (response.status === 200) {
    return response.data;
  }
}

export async function removePlayer(username) {
  const response = await axios.post(
    `${process.env.REACT_APP_API_URL}/team/player`,
    {
      username,
      withCredentials: true,
    }
  );
  if (response.status === 200) {
    return response.data;
  }
}

export async function invitePlayer(providedTeamId, playerName) {
  const response = await axios.post(
    `${process.env.REACT_APP_API_URL}/team/invite`,
    { providedTeamId, playerName },
    { withCredentials: true }
  );
  if (response.status === 200) {
    return response.data;
  }
}
