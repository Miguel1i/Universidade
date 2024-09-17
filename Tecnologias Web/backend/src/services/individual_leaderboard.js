import IndividualLeaderboard from "../models/individual_leaderboard.js";

export async function updateIndividualLeaderboard(username, score, seasonId) {
  const user = await IndividualLeaderboard.findOne({
    where: { username, seasonId },
  });
  if (!user) {
    const newUser = new IndividualLeaderboard({
      seasonId,
      username,
      score,
    });
    await newUser.save();
  } else {
    user.score += score;
    await user.save();
  }
}

export async function getIndividualLeaderboard(seasonId) {
  return await IndividualLeaderboard.findAll({
    where: { seasonId },
    order: [["score", "DESC"]],
  });
}
