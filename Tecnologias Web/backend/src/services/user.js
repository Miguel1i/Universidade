import bcrypt from "bcrypt";
import User from "../models/user.js";
import { UserExistError } from "../errors/user.js";
import { createPlayer } from "../services/player.js";

/* FROM DATABASE */

// Get all users
export async function getAllUsers() {
  return await User.findAll();
}

// Get user by username
export async function getUser(username) {
  return await User.findByPk(username);
}

function generatePasswordHash(password) {
  const saltRounds = 10;
  return new Promise((resolve, reject) => {
    bcrypt.hash(password, saltRounds, function (err, hash) {
      if (err) {
        return reject(err);
      }
      return resolve(hash);
    });
  });
}

// Create user
export async function create(user) {
  const passwordHash = await generatePasswordHash(user.password);
  delete user["password"];

  const newUser = new User({
    ...user,
    passwordHash: passwordHash,
  });

  try {
    await newUser.save();
    createPlayer(user.username);
  } catch (err) {
    if (err.name === "SequelizeUniqueConstraintError") {
      throw new UserExistError();
    }
    console.log(instaerr);
  }

  return newUser;
}

// Update user
export async function update(username, updatedUser) {
  const user = await getUser(username);
  if (user) {
    await user.update(updatedUser);
  }
}

// Delete user
export async function remove(username) {
  const user = await getUser(username);
  if (user) {
    await user.destroy();
  }
}
