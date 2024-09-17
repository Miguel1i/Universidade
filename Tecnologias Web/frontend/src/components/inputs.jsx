import styled, { css } from "styled-components";

export default function Inputs(props) {
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
        background-color: black; /* Change background color to black when clicked */
        color: white; /* Change text color to white when clicked */
      `}

    &:hover {
      background-color: black; /* Change background color to black when hovered */
      color: white; /* Change text color to white when hovered */
    }
  `;
  const { value, type, name, func } = props;

  return (
    <Inputs type={type} name={name} id={value} value={value} onClick={func} />
  );
}
