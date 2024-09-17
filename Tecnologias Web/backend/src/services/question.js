import { Question } from "../models/question.js";
import {
  BlanksQuestionType,
  BooleanQuestionType,
  MultipleValidQuestionType,
  OneValidQuestionType,
  QuestionType,
  difficulty,
} from "../models/question.js";

export async function getAllQuestions() {
  return await Question.find({});
}

export async function generateGameQuestions(providedDifficulty) {
  let questions = [];

  if (providedDifficulty === difficulty.EASY) {
    questions = await Promise.all([getQuestions(difficulty.EASY, 20)]);
  } else if (providedDifficulty === difficulty.MODERATE) {
    questions = await Promise.all([
      getQuestions(difficulty.EASY, 10),
      getQuestions(difficulty.MODERATE, 10),
    ]);
  } else if (providedDifficulty === difficulty.HARD) {
    questions = await Promise.all([
      getQuestions(difficulty.EASY, 5),
      getQuestions(difficulty.MODERATE, 5),
      getQuestions(difficulty.HARD, 10),
    ]);
  }

  return questions.flat();
}

async function getQuestions(providedDifficulty, sampleSize) {
  return await Question.aggregate()
    .match({ difficulty: providedDifficulty })
    .sample(sampleSize);
}

export async function seedQuestionTypes() {
  const types = [
    { description: BooleanQuestionType },
    { description: BlanksQuestionType },
    { description: OneValidQuestionType },
    { description: MultipleValidQuestionType },
  ];

  const questionTypeCount = await QuestionType.countDocuments();
  if (questionTypeCount == 0) {
    await QuestionType.insertMany(types);
  }
}

export async function validateAnswer(questionDesciption, awnser) {
  const question = await Question.findOne({ description: questionDesciption });
  const options = question.options;
  for (const option of options) {
    if (option.title === awnser) {
      if (option.correct) {
        return question.points;
      }
    }
  }
  return 0;
}
