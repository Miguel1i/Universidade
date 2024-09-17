import { getUser } from "./user.js";
import bcrypt from "bcrypt";

export const login = async (username, password) => {
  const user = await getUser(username);
  if (!user) {
    return null;
  }

  const isValid = await bcrypt.compare(password, user.passwordHash);
  console.log(isValid);
  if (!isValid) {
    return null;
  }

  return user;
};
