import { Router } from "express";
import { getAllQuestions } from "../services/question.js";

const router = Router();

router.get("/", async (req, res) => {
  res.json(await getAllQuestions());
});

/*
router.get("/vf", (req, res) => {
  let questao = "O Counter-Strike começou como um mod do Half-Life.";
  let opcoes = ["Verdadeiro", "Falso"];
  let imagem = "/images/half-life-logo.jpg";
  res.render("questao_vf", {
    question: questao,
    options: opcoes,
    image: imagem,
  });
});

router.get("/espacos", (req, res) => {
  let questao = "O jogador com mais MVPs é";
  let opcoes = ["s1mple", "coldzera", "device", "NiKo"];
  let imagem = "/images/mvp.png";
  res.render("questao_espacos", {
    question: questao,
    options: opcoes,
    image: imagem,
  });
});

router.get("/mais1", (req, res) => {
  let questao = "Quais são essas granadas?";
  let opcoes = ["Molotov", "HE", "Decoy", "Flashbang"];
  let imagem = "/images/granadas.png";
  res.render("questao_mais1", {
    question: questao,
    options: opcoes,
    image: imagem,
  });
});

router.get("/m1", (req, res) => {
  let questao = "Qual é esta skin?";
  let opcoes = ["Asiimov", "Dragon Lore", "Medusa", "Redline"];
  let imagem = "/images/dlore.png";
  res.render("questao_m1", {
    question: questao,
    options: opcoes,
    image: imagem,
  });
});
*/

router.get("/score", (req, res) => {
  res.render("score", {
    score: "189"
  });
})

export default router;
