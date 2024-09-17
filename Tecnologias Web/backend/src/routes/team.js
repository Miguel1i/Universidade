import { Router } from "express";
import {
  createTeam,
  invitePlayer,
  getTeam,
  getPlayers,
  removePlayer,
} from "../services/team.js";

const router = Router();

router.post("/", async (req, res) => {
  const { teamName, captain } = req.body;
  await createTeam(teamName, captain);
  res.json({});
});

router.post("/invite", async (req, res) => {
  const { providedTeamId, playerName } = req.body;
  await invitePlayer(providedTeamId, playerName);
  res.json({});
});

router.get("/players", async (req, res) => {
  const { teamId } = req.query;
  if (teamId) {
    const players = await getPlayers(teamId);
    res.json(players);
  }
});

router.get("/team", async (req, res) => {
  const { teamName } = req.query;
  const team = await getTeam(teamName);
  return res.json(team);
});

router.get("/captain"),
  async (req, res) => {
    const { username } = req.query;
    const isCaptain = await checkCaptain(username);
    res.json(isCaptain);
  };

router.post("/player", async (req, res) => {
  const { username } = req.body;
  await removePlayer(username);
  res.status(200).send();
});

export default router;
