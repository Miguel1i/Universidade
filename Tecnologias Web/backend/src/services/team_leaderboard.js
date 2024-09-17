import TeamLeaderboard from "../models/team_leaderboard.js";

export async function updateTeamLeaderboard(teamName, score, seasonId) {
  try {
    const team = await TeamLeaderboard.findOne({
      where: { teamName, seasonId },
    });
    if (!team) {
      const newTeam = new TeamLeaderboard({
        seasonId,
        teamName,
        score,
      });
      await newTeam.save();
    } else {
      team.score += score;
      await team.save();
    }
  } catch (error) {
    console.error("Error updating team leaderboard:", error);
    throw new Error("Failed to update team leaderboard");
  }
}
export async function getTeamLeaderboard(seasonId) {
  return await TeamLeaderboard.findAll({
    where: { seasonId },
    order: [["score", "DESC"]],
  });
}
