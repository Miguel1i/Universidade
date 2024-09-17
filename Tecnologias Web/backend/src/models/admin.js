import dotenv from "dotenv";
import { DataTypes, Model } from "sequelize";
import Sequelize from "sequelize";

dotenv.config();

const { DB_USER, DB_PASSWORD, DB_HOST, DB } = process.env;
const sequelize = new Sequelize(
  `mysql://${DB_USER}:${DB_PASSWORD}@${DB_HOST}/${DB}`
);

class Admin extends Model {}
Admin.init(
  {
    AdminId: {
      type: DataTypes.INTEGER,
      allowNull: false,
      primaryKey: true,
      autoIncrement: true,
      defaultValue: 1,
    },
    username: {
      type: DataTypes.STRING,
      allowNull: false,
    },
  },
  { sequelize, modelName: "admins" }
);

export default Admin;
