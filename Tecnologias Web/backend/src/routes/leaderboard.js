import { Router } from "express";
import {
  getIndividualLeaderboard,
  updateIndividualLeaderboard,
} from "../services/individual_leaderboard.js";
import {
  getTeamLeaderboard,
  updateTeamLeaderboard,
} from "../services/team_leaderboard.js";

const router = Router();

router.get("/individual", async (req, res) => {
  const { seasonId } = req.query;
  try {
    const leaderboard = await getIndividualLeaderboard(seasonId);
    return res.json(leaderboard);
  } catch (error) {
    console.error("Error fetching individual leaderboard:", error);
    return res.status(500).json({ error: "Internal server error" });
  }
});

router.get("/team", async (req, res) => {
  const { seasonId } = req.query;
  try {
    const leaderboard = await getTeamLeaderboard(seasonId);
    return res.json(leaderboard);
  } catch (error) {
    console.error("Error fetching team leaderboard:", error);
    return res.status(500).json({ error: "Internal server error" });
  }
});

router.post("/individual", async (req, res) => {
  const { entityName, score, seasonId } = req.body;
  await updateIndividualLeaderboard(entityName, score, seasonId);
  return res.json({});
});

router.post("/team", async (req, res) => {
  const { entityName, score, seasonId } = req.body;
  await updateTeamLeaderboard(entityName, score, seasonId);
  return res.json({});
});

export default router;
