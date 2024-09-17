import { Router } from "express";
import { create, getAllUsers, getUser, remove } from "../services/user.js";
import { checkSchema, validationResult, matchedData } from "express-validator";
import { UserExistError } from "../errors/user.js";
import { validateSchema } from "../middlewares/validation.js";

const router = Router();

router.get("/", async (req, res) => {
  const result = await getAllUsers();
  if (!result || result.length <= 0) {
    return res.status(204).send();
  }
  return res.json(result);
});

/*
router.get("/:username", async (req, res) => {
  const { username } = req.params;

  const user = await getUser(username);
  if (!user) {
    return res.status(204).send();
  }
  delete user["passwordHash"];
  return res.json(user);
});
*/

router.delete("/:username", async (req, res) => {
  const { username } = req.params;
  await remove(username);
  return res.send();
});

const userSchema = checkSchema({
  username: {
    errorMessage: "Invalid username",
  },
  email: {
    errorMessage: "Invalid email",
    isEmail: true,
  },
  firstName: {
    errorMessage: "Invalid first name",
  },
  lastName: {
    errorMessage: "Invalid last name",
  },
  password: {
    errorMessage: "Invalid password",
    isStrongPassword: false,
    isLength: {
      options: { min: 5 },
      errorMessage: "Password should be at least 5 chars",
    },
  },
});

router.get("/registo", (req, res) => {
  res.render("registo");
});

router.post("/", [userSchema, validateSchema], async (req, res) => {
  try {
    return res.json(await create(req.body));
  } catch (err) {
    if (err instanceof UserExistError) {
      return res.status(409).send(err.message);
    }
    return res.status(400).json(err);
  }
});

export default router;
