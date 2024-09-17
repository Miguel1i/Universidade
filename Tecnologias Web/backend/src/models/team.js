import dotenv from "dotenv";
import { DataTypes, Model } from "sequelize";
import Sequelize from "sequelize";

dotenv.config();

const { DB_USER, DB_PASSWORD, DB_HOST, DB } = process.env;
const sequelize = new Sequelize(
  `mysql://${DB_USER}:${DB_PASSWORD}@${DB_HOST}/${DB}`
);

class Team extends Model {}
Team.init(
  {
    teamId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      primaryKey: true,
      autoIncrement: true,
    },
    teamName: {
      type: DataTypes.STRING,
      allowNull: false,
    },
    captain: {
      type: DataTypes.STRING,
      allowNull: false,
    },
  },
  { sequelize, modelName: "teams" }
);

export default Team;
