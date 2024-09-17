import { Season } from "../models/season.js";

async function getNextSeasonId() {
  const seasons = await Season.find({});
  if (seasons.length === 0) {
    return 1;
  }
  return seasons[seasons.length - 1].seasonId + 1;
}

export async function createSeason(seasonName, inicialDate, finalDate) {
  const seasonId = await getNextSeasonId();
  const season = new Season({
    seasonId,
    seasonName,
    inicialDate,
    finalDate,
  });
  await season.save();
}

export async function validateGame(createdAtDate) {
  const season = await Season.find({
    inicialDate: { $lte: createdAtDate },
    finalDate: { $gte: createdAtDate },
  });
  if (season.length === 0) {
    return null;
  }
  return season;
}

export async function getCurrentSeasonId() {
  const currentDate = new Date();
  const season = await Season.find({
    inicialDate: { $lte: currentDate },
    finalDate: { $gte: currentDate },
  });
  if (season.length === 0) {
    return null;
  }
  return season[0].seasonId;
}
