import { RouterProvider, createBrowserRouter } from "react-router-dom";
import Home from "./pages/Home.jsx";
import Login from "./pages/Login.jsx";
import Menu from "./pages/Menu.jsx";
import styled from "styled-components";
import { AuthContext } from "./Context.js";
import { useEffect, useState } from "react";
import { get } from "./services/Auth.js";
import ProtectedRoute from "./components/ProtectedRoute.jsx";
import Question from "./pages/Pergunta_m1.jsx";
import dlore from "./assets/images/dlore.png";
import Regist from "./pages/Regist.jsx";
import Endscreen from "./pages/Endscreen.jsx";
import Criar from "./pages/Criar.jsx";
import Leaderboard from "./pages/Leaderboard.jsx";
import Team from "./pages/Team.jsx";
import Member from "./pages/MemberPage.jsx";
import Captain from "./pages/CaptainPage.jsx";
import Game from "./pages/Game.jsx";

const MainComponent = styled.div`
  background-color: #282c34;
  color: white;
`;

function App() {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);
  useEffect(() => {
    get()
      .then((u) => {
        if (u) {
          setUser(u);
        }
        setLoading(false);
      })
      .catch(() => setLoading(false));
  }, [setUser]);

  const router = createBrowserRouter([
    {
      path: "/",
      element: <Login />,
    },
    {
      path: "/login",
      element: <Login />,
    },
    {
      path: "/home",
      element: (
        <ProtectedRoute>
          <Home />
        </ProtectedRoute>
      ),
    },
    {
      path: "/menu",
      element: <Menu />,
    },
    {
      path: "/pergunta",
      element: (
        <Question
          source={dlore}
          title={"Que skin é esta?"}
          answers={["Dlore", "Redline", "Asiimov", "Medusa"]}
        />
      ),
    },
    {
      path: "/registo",
      element: <Regist />,
    },
    {
      path: "/endscreen",
      element: <Endscreen score={"50 / 100"} />,
    },
    {
      path: "/criar",
      element: <Criar />,
    },
    {
      path: "/leaderboard",
      element: <Leaderboard />,
    },
    {
      path: "/equipa",
      element: (
        <ProtectedRoute>
          <Team />
        </ProtectedRoute>
      ),
    },
    {
      path: "/member",
      element: (
        <ProtectedRoute>
          <Member />
        </ProtectedRoute>
      ),
    },
    {
      path: "/captain",
      element: (
        <ProtectedRoute>
          <Captain />
        </ProtectedRoute>
      ),
    },
    {
      path: "/game",
      element: <Game />,
    },
  ]);
  return (
    <AuthContext.Provider value={{ user, setUser, loading }}>
      <MainComponent>
        <RouterProvider router={router} />
      </MainComponent>
    </AuthContext.Provider>
  );
}

export default App;
