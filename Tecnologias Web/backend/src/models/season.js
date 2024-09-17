import mongoose from "mongoose";

const { Schema } = mongoose;

const seasonSchema = new Schema({
  seasonId: {
    type: Number,
    required: true,
  },
  seasonName: {
    type: String,
    required: true,
  },
  inicialDate: {
    type: Date,
    required: true,
  },
  finalDate: {
    type: Date,
    required: true,
  },
});

export const Season = mongoose.model("Seasons", seasonSchema);
