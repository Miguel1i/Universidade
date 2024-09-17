import { Router } from "express";
import { createAdmin, getAdmin } from "../services/admin.js";

const router = Router();

router.post("/", async (req, res) => {
  const { username } = req.body;
  await createAdmin(username);
  res.json({});
});

router.get("/", async (req, res) => {
  const { username } = req.body;
  const admin = await getAdmin(username);
  res.json(admin);
});

export default router;
