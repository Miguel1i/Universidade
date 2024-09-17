import { Router } from "express";
import { createSeason, getCurrentSeasonId } from "../services/season.js";

const router = Router();

router.post("/", (req, res) => {
  const { seasonName, inicialDate, finalDate } = req.body;
  const inicialDateObj = new Date(inicialDate);
  const finalDateObj = new Date(finalDate);
  const currentDate = new Date();
  if (!seasonName || !inicialDateObj || !finalDateObj) {
    return res.status(400).send();
  } else if (inicialDateObj === finalDateObj) {
    return res.status(400).send();
  } else if (inicialDateObj > finalDateObj) {
    return res.status(400).send();
  } else if (finalDateObj < currentDate) {
    return res.status(400).send();
  }
  createSeason(seasonName, inicialDate, finalDate);
  res.json({});
});

router.get("/", async (req, res) => {
  const currentSeasonId = await getCurrentSeasonId();
  return res.json({ currentSeasonId });
});

export default router;
