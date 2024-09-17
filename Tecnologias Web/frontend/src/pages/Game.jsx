import { useLocation } from "react-router";
import { useState, useEffect } from "react";
import text from "../assets/images/text.png";
import { ContainerStyled } from "../components/ContainerStyled";
import Video from "../components/Video";
import { Options } from "../components/Options.jsx";
import styled, { css } from "styled-components";
import { Anchor } from "../components/Anchor";
import { Title } from "../components/Title";
import { Paragrafo } from "../components/Paragrafo";
import { SubmitButton } from "../components/Form";
import { updateGame } from "../services/Game.js";
import Clock from "../components/clock.jsx";
import {
  updateIndividualLeaderboard,
  updateTeamLeaderboard,
} from "../services/Leaderboard.js";

const Inputs = styled.input`
  padding: 10px 20px;
  font-size: large;
  height: 70px;
  cursor: pointer;
  background-color: white;
  color: black;
  border: 1px solid black;
  border-radius: 10px;
  transition: background-color 0.3s;
  width: 350px;
  display: flex;
  justify-content: center;
  align-items: center;

  ${(props) =>
    props.clicked &&
    css`
      background-color: black;
      color: white;
    `}

  &:hover {
    background-color: black;
    color: white;
  }
`;

export default function Game() {
  const location = useLocation();
  const { state } = location || {};
  const { game, questions, entityName, modeBool, difficultyInt } = state || {};
  const [currentQuestionIndex, setCurrentQuestionIndex] = useState(0);
  const [count, setCount] = useState(null);
  const gameId = game[0].gameId;
  const seasonId = game[0].seasonId;
  const [gameStatus, setGameStatus] = useState(true);
  const [score, setScore] = useState(0);

  useEffect(() => {
    const defaultTime = 300;
    if (count === null) {
      if (difficultyInt === 0) {
        setCount(defaultTime);
      } else if (difficultyInt === 1) {
        setCount(defaultTime * 1.25);
      } else {
        setCount(defaultTime * 1.5);
      }
    }
  }, [count, difficultyInt]);

  function nextQuestion() {
    if (currentQuestionIndex < questions.length - 1) {
      setCurrentQuestionIndex(currentQuestionIndex + 1);
    } else {
      setGameStatus(false);
    }
  }

  useEffect(() => {
    if (!gameStatus) {
      const updateLeaderboard = async () => {
        if (modeBool) {
          await updateIndividualLeaderboard(entityName, score, seasonId);
        } else {
          await updateTeamLeaderboard(entityName, score, seasonId);
        }
      };
      updateLeaderboard();
    }
  }, [gameStatus, entityName, modeBool, score, seasonId]);

  function renderQuestion() {
    if (!gameStatus) {
      return <Endscreen score={score} />;
    }

    if (!game) {
      return <p>Loading game...</p>;
    }

    if (questions.length === 0) {
      return <p>No questions available.</p>;
    }

    const question = questions[currentQuestionIndex];

    switch (question.type) {
      case "boolean":
        return (
          <Boolean
            question={question}
            onNext={nextQuestion}
            options={question.options}
            gameId={gameId}
            setScore={setScore}
          />
        );
      case "blanks":
        return (
          <Blanks
            question={question}
            onNext={nextQuestion}
            options={question.options}
            gameId={gameId}
            setScore={setScore}
          />
        );
      case "oneValid":
        return (
          <OneValid
            question={question}
            onNext={nextQuestion}
            options={question.options}
            gameId={gameId}
            setScore={setScore}
          />
        );
      case "multipleValid":
        return (
          <MultipleValid
            question={question}
            onNext={nextQuestion}
            options={question.options}
            gameId={gameId}
            setScore={setScore}
          />
        );
      default:
        return <Endscreen score={score} />;
    }
  }

  return (
    <>
      <Video />
      <Clock setCount={setCount} count={count} />
      <div>{renderQuestion()}</div>
    </>
  );
}

function QuestionHeader({ question, children }) {
  return (
    <ContainerStyled>
      <img src={text} alt="question" style={{ marginBottom: "5%" }} />
      <p style={{ fontSize: "30px", marginBottom: "40px" }}>
        {question.description}
      </p>
      {children}
    </ContainerStyled>
  );
}

function Navigation({ onNext, answer, gameId, questionDescription, setScore }) {
  async function atualizarGame(answer) {
    if (questionDescription !== null) {
      const points = await updateGame(gameId, questionDescription, answer);
      if (points !== null) {
        setScore((prevScore) => prevScore + points.points);
      }
    }
  }

  return (
    <button
      type="button"
      onClick={() => {
        atualizarGame(answer);
        onNext();
      }}
      style={{ fontSize: "25px", borderRadius: "5px" }}
    >
      Next
    </button>
  );
}

function Boolean({ question, onNext, options, gameId, setScore }) {
  const [clickedIndex, setClickedIndex] = useState(null);
  const [answer, setAnswer] = useState(null);

  const handleClick = (index, answer) => {
    setClickedIndex(index === clickedIndex ? null : index);
    setAnswer(answer);
  };

  return (
    <QuestionHeader question={question}>
      <Options>
        {options.length > 0 ? (
          options.map((option, index) => (
            <Inputs
              key={index}
              type="button"
              value={option.title}
              clicked={clickedIndex === index}
              onClick={() => handleClick(index, option.title)}
            />
          ))
        ) : (
          <p>No options available</p>
        )}
      </Options>
      <Navigation
        onNext={onNext}
        answer={answer}
        gameId={gameId}
        questionDescription={question.description}
        setScore={setScore}
      />
    </QuestionHeader>
  );
}

function Blanks({ question, onNext, options, gameId, setScore }) {
  const [answer, setAnswer] = useState(null);

  return (
    <QuestionHeader question={question}>
      <input
        type="text"
        placeholder="Answer"
        style={{
          fontSize: "20px",
          height: "50px",
          width: "350px",
          marginBottom: "20px",
        }}
        onChange={(e) => setAnswer(e.target.value)}
      />
      <Options>
        {options.length > 0 ? (
          options.map((option, index) => (
            <Inputs key={index} type="button" value={option.title} />
          ))
        ) : (
          <p>No options available</p>
        )}
      </Options>
      <Navigation
        onNext={onNext}
        answer={answer}
        gameId={gameId}
        questionDescription={question.description}
        setScore={setScore}
      />
    </QuestionHeader>
  );
}

function OneValid({ question, onNext, options, gameId, setScore }) {
  const [clickedIndex, setClickedIndex] = useState(null);
  const [answer, setAnswer] = useState(null);

  const handleClick = (index, answer) => {
    setClickedIndex(index === clickedIndex ? null : index);
    setAnswer(answer);
  };

  return (
    <QuestionHeader question={question}>
      <Options>
        {options.length > 0 ? (
          options.map((option, index) => (
            <Inputs
              key={index}
              type="button"
              value={option.title}
              clicked={clickedIndex === index}
              onClick={() => handleClick(index, option.title)}
            />
          ))
        ) : (
          <p>No options available</p>
        )}
      </Options>
      <Navigation
        onNext={onNext}
        answer={answer}
        gameId={gameId}
        questionDescription={question.description}
        setScore={setScore}
      />
    </QuestionHeader>
  );
}

function MultipleValid({ question, onNext, options, gameId, setScore }) {
  const [clickedIndices, setClickedIndices] = useState([]);
  const [answer, setAnswer] = useState([]);

  const handleClick = (index, title) => {
    let newClickedIndices;
    let newAnswer;

    const correctAnswerLength = options.filter(
      (option) => option.correct
    ).length;

    if (clickedIndices.includes(index)) {
      newClickedIndices = clickedIndices.filter((i) => i !== index);
      newAnswer = answer.filter((ans) => ans !== title);
    } else if (clickedIndices.length < correctAnswerLength) {
      newClickedIndices = [...clickedIndices, index];
      newAnswer = [...answer, title];
    } else {
      newClickedIndices = [clickedIndices[1], index];
      newAnswer = [answer[1], title];
    }

    setClickedIndices(newClickedIndices);
    setAnswer(newAnswer);
  };

  return (
    <QuestionHeader question={question}>
      <Options>
        {options.length > 0 ? (
          options.map((option, index) => (
            <Inputs
              key={index}
              type="button"
              value={option.title}
              clicked={clickedIndices.includes(index)}
              onClick={() => handleClick(index, option.title)}
            />
          ))
        ) : (
          <p>No options available</p>
        )}
      </Options>
      <Navigation
        onNext={onNext}
        answer={answer}
        gameId={gameId}
        questionDescription={question.description}
        setScore={setScore}
      />
    </QuestionHeader>
  );
}

function Endscreen({ score }) {
  return (
    <>
      <Video />
      <ContainerStyled>
        <Title>Pontuação</Title>
        <Paragrafo>{score} pts.</Paragrafo>
        <SubmitButton>
          <Anchor href="/menu">Home</Anchor>
        </SubmitButton>
      </ContainerStyled>
    </>
  );
}
