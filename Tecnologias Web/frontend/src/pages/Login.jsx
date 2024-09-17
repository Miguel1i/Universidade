import { styled } from "styled-components";
import { Formik } from "formik";
import * as Yup from "yup";
import { login } from "../services/Auth.js";
import { useNavigate } from "react-router";
import { useAuth } from "../Context.js";
import { useEffect } from "react";
import DefaultLayout from "../layouts/DefaultLayout.jsx";
import text from "../assets/images/text.png";
import Image from "../components/Image.jsx";
import backgroundDivided from "../assets/images/backgroundDivided.png";
import {
  Input,
  InputErrorLabel,
  SubmitButton,
  InputContainer,
} from "../components/Form.jsx";

const Container = styled.div`
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 30%;
`;

const Header = styled.h1`
  @import url("https://fonts.cdnfonts.com/css/counter-strike");
  color: white;
  font-size: 64px;
  margin-left: 2%;
  margin-bottom: 5%;
  margin-top: 20%;
  font-family: "Counter-Strike";
  font-weight: 500;
  word-wrap: break-word;
`;

const Paragrafo = styled.p`
  margin-top: 6%;
  color: white;
  font-size: 30px;
  margin-bottom: 2%;
  font-family: "Counter-Strike";
  font-weight: 500;
  word-wrap: break-word;
  text-decoration: underline;
`;

const Anchor = styled.a`
  text-decoration: none;
  color: white;
`;

export default function Login() {
  const { user, loading, setUser } = useAuth();
  const navigate = useNavigate();

  useEffect(() => {
    if (user && !loading) {
      navigate("/home");
    }
  }, [user, loading, navigate]);

  return (
    <DefaultLayout background={backgroundDivided}>
      <Container>
        <Image source={text} style={{ marginTop: "20%" }}></Image>
        <Header>Login</Header>
        <Formik
          initialValues={{ username: "", password: "" }}
          validationSchema={Yup.object({
            username: Yup.string().required("Username is required"),
            password: Yup.string().required("Password is required"),
          })}
          onSubmit={async (values, { setSubmitting }) => {
            setSubmitting(true);
            const user = await login(values.username, values.password);

            if (user) {
              setUser(user);
              navigate("/menu");
            } else {
            }
          }}
        >
          {({
            values,
            errors,
            touched,
            handleChange,
            handleBlur,
            handleSubmit,
            isSubmitting,
          }) => (
            <form onSubmit={handleSubmit}>
              <InputContainer>
                <Input
                  type="text"
                  placeholder="Username"
                  name="username"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.username}
                />
                <InputErrorLabel>
                  {errors.username && touched.username && errors.username}
                </InputErrorLabel>
              </InputContainer>
              <InputContainer>
                <Input
                  type="password"
                  placeholder="Password"
                  name="password"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.password}
                />
                <InputErrorLabel>
                  {errors.password && touched.password && errors.password}
                </InputErrorLabel>
              </InputContainer>
              <SubmitButton type="submit" disabled={isSubmitting}>
                LOGIN
              </SubmitButton>
            </form>
          )}
        </Formik>
        <Paragrafo>
          <Anchor href="/registo">Criar Conta</Anchor>
        </Paragrafo>
      </Container>
    </DefaultLayout>
  );
}
