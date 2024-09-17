import dotenv from "dotenv";
import { DataTypes, Model } from "sequelize";
import Sequelize from "sequelize";

dotenv.config();

const { DB_USER, DB_PASSWORD, DB_HOST, DB } = process.env;
const sequelize = new Sequelize(
  `mysql://${DB_USER}:${DB_PASSWORD}@${DB_HOST}/${DB}`
);

class Player extends Model {}
Player.init(
  {
    username: {
      type: DataTypes.STRING,
      allowNull: false,
      primaryKey: true,
    },
    teamId: {
      type: DataTypes.INTEGER,
      allowNull: true,
    },
  },
  { sequelize, modelName: "players" }
);

export default Player;
