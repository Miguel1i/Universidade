import { Router } from "express";
import { authGuard } from "../middlewares/authGuard.js";
import { checkSchema } from "express-validator";
import { validateSchema } from "../middlewares/validation.js";
import { generateGameQuestions } from "../services/question.js";
import {
  createGame,
  getNextGameId,
  updateGame,
  getGameResult,
} from "../services/game.js";
import { validateGame } from "../services/season.js";
const router = Router();

const gameStartSchema = checkSchema({
  difficulty: {
    errorMessage: "Invalid difficulty",
    isNumeric: true,
    notEmpty: true,
  },
});

router.get("/", [gameStartSchema, validateSchema], async (req, res) => {
  const { entityName, difficulty } = req.query;
  const validSeason = await validateGame(new Date());
  if (!validSeason) {
    return res.status(400).send();
  }
  const difficultyInt = parseInt(difficulty);
  const questions = await generateGameQuestions(difficultyInt);
  const gameId = await getNextGameId();
  const game = await createGame(
    gameId,
    validSeason[0].seasonId,
    questions,
    entityName
  );
  return res.send({ game, questions });
});

router.post("/updateGame", async (req, res) => {
  const { providedGameId, questionDescription, providedAnswer } = req.body;
  const points = await updateGame(
    providedGameId,
    questionDescription,
    providedAnswer
  );
  return res.send({ points });
});

export default router;
