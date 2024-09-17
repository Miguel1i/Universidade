import styled from "styled-components";

export const Input = styled.input`
  display: flex;
  flex-direction: column;
  height: 40px;
  width: 300px;
  border: none;
`;

export const RadioInput = styled.input`
  display: flex;
  flex-direction: column;
  height: 20px;
  width: 100px;
  border: none;
`;

export const InputContainer = styled.div`
  display: flex;
  flex-direction: column;
  justify-content: start;
  align-items: start;
  margin-bottom: 20px;
`;

export const InputErrorLabel = styled.label`
  color: red;
  font-size: 12px;
`;

export const SubmitButton = styled.button`
  height: 40px;
  width: 300px;
  border: none;
`;
