import Game from "../models/game.js";
import { validateAnswer } from "./question.js";

export async function updateGame(
  providedGameId,
  questionDescription,
  providedAnswer
) {
  try {
    var points = 0;
    var concatenatedAnswer = "";

    if (Array.isArray(providedAnswer)) {
      for (const answer of providedAnswer) {
        points = await validateAnswer(questionDescription, answer);
        concatenatedAnswer += answer + ", ";
      }
      concatenatedAnswer = concatenatedAnswer.slice(0, -2);
    } else {
      points = await validateAnswer(questionDescription, providedAnswer);
      concatenatedAnswer = providedAnswer;
    }

    await Game.updateOne(
      { gameId: providedGameId, questionDescription },
      {
        $set: {
          answer: concatenatedAnswer,
          points,
        },
      }
    );
    return points;
  } catch (error) {
    console.error(
      `Error updating game with ID ${providedGameId} for question ${questionDescription}:`,
      error
    );
  }
}

export async function getGameResult(providedGameId) {
  try {
    const games = await Game.find({ gameId: providedGameId });

    const totalPoints = games.reduce((total, game) => total + game.points, 0);

    return totalPoints;
  } catch (error) {
    console.error("Error fetching game result:", error);
    throw error;
  }
}

export async function getNextGameId() {
  const games = await Game.find({});
  if (games.length === 0) {
    return 1;
  }
  return games[games.length - 1].gameId + 1;
}

export async function createGame(gameId, seasonId, questionsArray, entityName) {
  const answer = "answer";
  const points = 0;
  const gameArray = [];

  try {
    if (!Array.isArray(questionsArray) || questionsArray.length === 0) {
      throw new Error("Invalid questionsArray format or empty array.");
    }

    for (const question of questionsArray) {
      const { description } = question;

      const game = new Game({
        gameId,
        seasonId,
        questionDescription: description,
        entityName,
        answer,
        points,
      });

      await game.save();

      gameArray.push(game);
    }

    return gameArray;
  } catch (error) {
    console.error("Error creating game:", error);
    throw error;
  }
}
