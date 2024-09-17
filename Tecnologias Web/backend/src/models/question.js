import mongoose from "mongoose";

const { Schema } = mongoose;

const StringRequiredType = {
  type: String,
  required: true,
};

export const difficulty = Object.freeze({
  EASY: 0,
  MODERATE: 1,
  HARD: 2,
});

export const BooleanQuestionType = "boolean";
export const BlanksQuestionType = "blanks";
export const OneValidQuestionType = "oneValid";
export const MultipleValidQuestionType = "multipleValid";

const questionTypeSchema = new Schema({
  description: StringRequiredType,
});

const questionSchema = new Schema({
  image: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    required: true,
  },
  type: {
    type: Schema.Types.ObjectId,
    ref: "QuestionTypes",
    required: true,
  },
  difficulty: {
    type: Number,
    required: true,
  },
  options: [
    {
      title: {
        type: String,
        required: true,
      },
      correct: {
        type: Boolean,
      },
    },
  ],
  points: {
    type: Number,
    required: true,
    default: function () {
      if (this.difficulty === difficulty.EASY) {
        return 1;
      } else if (this.difficulty === difficulty.MODERATE) {
        return 2;
      } else if (this.difficulty === difficulty.HARD) {
        return 3;
      }
    },
  },
});

export const Question = mongoose.model("questions", questionSchema);
export const QuestionType = mongoose.model("questionTypes", questionTypeSchema);
