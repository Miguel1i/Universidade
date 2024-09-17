import mongoose from "mongoose";

const { Schema } = mongoose;

const gameSchema = new Schema({
  gameId: {
    type: Number,
    required: true,
  },
  seasonId: {
    type: Number,
    required: true,
  },
  questionDescription: {
    type: String,
    required: true,
  },
  entityName: {
    type: String,
    required: true,
  },
  answer: {
    type: String,
    required: true,
  },
  points: {
    type: Number,
    required: true,
  },
});

const Game = mongoose.model("Games", gameSchema);

export default Game;
