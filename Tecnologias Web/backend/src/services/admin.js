import Admin from "../models/admin.js";

export async function createAdmin(username) {
  const admin = await Admin.findOne({ username });
  if (admin) {
    console.log(`admin ${username} já existe`);
    return false;
  }
  const newAdmin = new Admin({
    username,
  });
  await newAdmin.save();
}

export async function getAdmin(username) {
  return await Admin.findOne({ username });
}
