import dotenv from "dotenv";
import User from "../models/user.js";
import mongoose from "mongoose";
import Admin from "../models/admin.js";
import Player from "../models/player.js";
import Team from "../models/team.js";
import MySQLStore from "express-mysql-session";
import session from "express-session";
import IndividualLeaderboard from "../models/individual_leaderboard.js";
import TeamLeaderboard from "../models/team_leaderboard.js";

dotenv.config();

// Establish connection to the database using .env credentials
const { DB, DB_USER, DB_PASSWORD, DB_HOST } = process.env;

export async function syncDatabase() {
  await User.sync();
  await Admin.sync();
  await IndividualLeaderboard.sync();
  await TeamLeaderboard.sync();
  await Player.sync();
  await Team.sync();
}

export const options = {
  host: DB_HOST,
  user: DB_USER,
  password: DB_PASSWORD,
  database: DB,
};

const DBSessionStore = MySQLStore(session);
export const sessionStore = new DBSessionStore(options);

mongoose
  .connect(process.env.MONGO_DB)
  .then(() => {
    console.log("Connected to MongoDB");
  })
  .catch((err) => {
    console.log(err);
    process.exit(-2);
  });
