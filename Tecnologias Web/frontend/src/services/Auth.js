import axios from "axios";

export async function login(username, password) {
  const response = await axios.post(
    `${process.env.REACT_APP_API_URL}/auth/`,
    { username, password },
    { withCredentials: true }
  );
  if (response.status === 200) {
    return await get();
  }
}

export async function get() {
  try {
    const response = await axios.get(`${process.env.REACT_APP_API_URL}/auth/`, {
      withCredentials: true,
    });

    if (response.status === 200) {
      return response.data;
    }
    return null;
  } catch {}

  return null;
}

export async function logout() {
  try {
    await axios.delete(`${process.env.REACT_APP_API_URL}/auth`, {
      withCredentials: true,
    });
  } catch {}
}
