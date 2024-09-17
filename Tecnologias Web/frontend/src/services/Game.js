import axios from "axios";

export async function generateGame(entityName, difficulty) {
  try {
    const response = await axios.get(`${process.env.REACT_APP_API_URL}/game/`, {
      params: { entityName, difficulty },
      withCredentials: true,
    });
    return response.data;
  } catch (error) {
    console.error("Error fetching game:", error);
    return null;
  }
}

export async function updateGame(
  providedGameId,
  questionDescription,
  providedAnswer
) {
  try {
    const response = await axios.post(
      `${process.env.REACT_APP_API_URL}/game/updateGame`,
      {
        providedGameId,
        questionDescription,
        providedAnswer,
      }
    );
    if (response.status === 200) {
      return response.data;
    }
  } catch (error) {
    console.error("Error updating game:", error);
    return null;
  }
}
