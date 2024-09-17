import React, { useState } from "react";
import PropTypes from "prop-types";
import styled, { css } from "styled-components";
import Clock from "../components/clock";
import Image from "../components/Image";

const P = styled.p`
  font-size: 32px;
  color: white;
  margin-bottom: 5%;
`;

const Container = styled.div`
  display: flex;
  align-items: center;
  flex-direction: column;
  margin-bottom: 20px;
`;

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

  ${props => props.clicked && css`
    background-color: black; /* Change background color to black when clicked */
    color: white; /* Change text color to white when clicked */
  `}

  &:hover {
    background-color: black; /* Change background color to black when hovered */
    color: white; /* Change text color to white when hovered */
  }
`;

const Options = styled.div`
  display: grid;
  grid-template-columns: 1fr 1fr; 
  grid-auto-rows: minmax(100px, auto); 
  gap: 10px; 
`;

export default function Question(props) {
  const { source, title, answers } = props;
  const [clickedIndex, setClickedIndex] = useState(null);

  const handleClick = index => {
    setClickedIndex(index === clickedIndex ? null : index); // Toggle clicked state
  };

  return (
    <Container>
      <Clock />
      <Image source={source} />
      <P>{title}</P>
      <Options>
        {answers.length > 0 ? (
          answers.map((answer, index) => (
            <Inputs
              key={index}
              type="button"
              id={answer}
              name="answer"
              value={answer}
              clicked={clickedIndex === index}
              onClick={() => handleClick(index)}
            />
          ))
        ) : (
          <p>No answers available</p>
        )}
      </Options>
    </Container>
  );
}

Question.defaultProps = {
  answers: [],
};

Question.propTypes = {
  source: PropTypes.string.isRequired,
  title: PropTypes.string.isRequired,
  answers: PropTypes.arrayOf(PropTypes.string),
};
