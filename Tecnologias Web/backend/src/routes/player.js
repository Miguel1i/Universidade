import { Router } from "express";
import { getPlayer, getTeamId } from "../services/player.js";
import { getTeam } from "../services/team.js";

const router = Router();

router.get("/player", async (req, res) => {
  const { playerName } = req.body;
  res.json(await getPlayer(playerName));
});

router.get("/team", async (req, res) => {
  const { username } = req.query;
  const teamId = await getTeamId(username);
  return res.json(await getTeam(teamId));
});

export default router;
