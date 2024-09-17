import express from "express";
import dotenv from "dotenv";
import userRoutes from "./src/routes/user.js";
import bodyParser from "body-parser";
import session from "express-session";
import authRoutes from "./src/routes/auth.js";
import questionRoutes from "./src/routes/question.js";
import leaderboardRoutes from "./src/routes/leaderboard.js";
import teamRoutes from "./src/routes/team.js";
import playerRoutes from "./src/routes/player.js";
import gameRoutes from "./src/routes/game.js";
import seasonRoutes from "./src/routes/season.js";
import adminRoutes from "./src/routes/admin.js";
import { syncDatabase } from "./src/services/database.js";
import { sessionStore } from "./src/services/database.js";
import cors from "cors";

// Configure environment variables
dotenv.config();
const port = process.env.PORT || 8000;

// Sync database
syncDatabase();

// Start express app
const app = express();

// Serve static files
app.use(express.static("public"));

// Configure template engine
app.set("view engine", "ejs");
app.set("views", "./src/views");

// Configure session
app.use(
  session({
    secret: process.env.SECRET,
    resave: true,
    saveUninitialized: false,
    store: sessionStore,
  })
);

// CORS
app.use(
  cors({
    credentials: true,
    origin: process.env.FRONTEND_URL,
  })
);

// Configure body parser
app.use(bodyParser.json());
app.use(bodyParser.urlencoded());

// Routes
app.use("/api/users", userRoutes);
app.use("/api/auth", authRoutes);
app.use("/api/question", questionRoutes);
app.use("/api/game", gameRoutes);
app.use("/api/season", seasonRoutes);
app.use("/api/team", teamRoutes);
app.use("/api/leaderboard", leaderboardRoutes);
app.use("/api/player", playerRoutes);
app.use("/api/admin", adminRoutes);

app.listen(port, () => {
  console.log(`Server is listening on port ${port}`);
});
