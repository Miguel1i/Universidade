import dotenv from "dotenv";
import { DataTypes, Model } from "sequelize";
import Sequelize from "sequelize";

dotenv.config();

const { DB_USER, DB_PASSWORD, DB_HOST, DB } = process.env;
const sequelize = new Sequelize(
  `mysql://${DB_USER}:${DB_PASSWORD}@${DB_HOST}/${DB}`
);

class TeamLeaderboard extends Model {}
TeamLeaderboard.init(
  {
    seasonId: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
    teamName: {
      type: DataTypes.STRING,
      allowNull: false,
      primaryKey: true,
    },
    score: {
      type: DataTypes.INTEGER,
      allowNull: false,
    },
  },
  { sequelize, modelName: "team_leaderboard" }
);

export default TeamLeaderboard;
