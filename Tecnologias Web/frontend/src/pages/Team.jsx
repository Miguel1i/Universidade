import { styled } from "styled-components";
import DefaultLayout from "../layouts/DefaultLayout";
import { createTeam, getTeam } from "../services/Team";
import { useEffect, useState, useContext } from "react";
import { useNavigate } from "react-router";
import { Formik } from "formik";
import * as Yup from "yup";
import { AuthContext } from "../Context";
import arrow from "../assets/images/arrow.png";

const Input = styled.input`
  display: flex;
  flex-direction: column;
  height: 40px;
  width: 300px;
  border: none;
  border-radius: 10px;
  padding: 3px;
`;

const SubmitButton = styled.button`
  height: 40px;
  width: 300px;
  border: none;
`;

const InputErrorLabel = styled.label`
  color: red;
  font-size: 12px;
`;

const InputContainer = styled.div`
  display: flex;
  flex-direction: column;
  justify-content: start;
  align-items: start;
  margin-bottom: 20px;
`;

const ContainerStyled = styled.div`
  position: absolute;
  z-index: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  width: 100%;
  top: 0;
  left: 0;
`;

export default function Team() {
  const navigate = useNavigate();
  const [records, setRecords] = useState([]);
  const { user } = useContext(AuthContext);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchTeam = async () => {
      try {
        const data = await getTeam(user?.username);
        setRecords(data);
      } catch (error) {
        console.error("Error fetching team data:", error);
      } finally {
        setLoading(false);
      }
    };
    fetchTeam();
  }, [user?.username]);

  useEffect(() => {
    if (!loading) {
      if (records.length === 0) {
        // If no team records are found, render the CreateTeam component
        return;
      } else {
        if (user?.username === records[0]?.captain) {
          navigate("/captain");
        } else {
          navigate("/member");
        }
      }
    }
  }, [loading, records, user?.username, navigate]);

  if (loading) {
    return <div>Loading...</div>;
  }

  if (records.length === 0) {
    return <CreateTeam />;
  }

  return null;
}

function CreateTeam() {
  const navigate = useNavigate();
  const { user } = useContext(AuthContext);

  return (
    <DefaultLayout>
      <ContainerStyled>
        <a href="/menu" style={{ marginLeft: "-93%", marginBottom: "10%" }}>
          <img
            src={arrow}
            style={{ width: "46px", height: "46px" }}
            alt="arrow"
          />
        </a>
        <Formik
          initialValues={{ teamName: "" }}
          validationSchema={Yup.object({
            teamName: Yup.string().required("Team Name is required"),
          })}
          onSubmit={async (values, { setSubmitting }) => {
            setSubmitting(true);
            try {
              const response = await createTeam(
                values.teamName,
                user?.username
              );
              if (response) {
                navigate("/captain");
              }
            } catch (error) {
              console.error("Error creating team:", error);
            } finally {
              setSubmitting(false);
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
            <form onSubmit={handleSubmit} style={{ marginBottom: "15%" }}>
              <InputContainer>
                <Input
                  type="text"
                  placeholder="Team Name"
                  name="teamName"
                  onChange={handleChange}
                  onBlur={handleBlur}
                  value={values.teamName}
                />
                <InputErrorLabel>
                  {errors.teamName && touched.teamName && errors.teamName}
                </InputErrorLabel>
              </InputContainer>
              <SubmitButton type="submit" disabled={isSubmitting}>
                Criar Equipa
              </SubmitButton>
            </form>
          )}
        </Formik>
      </ContainerStyled>
    </DefaultLayout>
  );
}
