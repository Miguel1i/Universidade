import axios from "axios";

export async function regist(username, email, firstName, lastName, password) {
  const response = await axios.post(`${process.env.REACT_APP_API_URL}/users`, {
    username,
    email,
    firstName,
    lastName,
    password,
  });

  if (response.status === 200) {
    return response.status;
  }

  return null;
}
