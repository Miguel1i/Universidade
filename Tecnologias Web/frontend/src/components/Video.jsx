import backgroundVideo from "../assets/videos/mirage-snow.webm";
import styled from "styled-components";

const VideoContainer = styled.div`
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  overflow: hidden;
  z-index: -1;
`;

export default function Video() {
  return (
    <VideoContainer>
      <video
        autoPlay
        loop
        muted
        src={backgroundVideo}
        style={{
          overflow: "hidden",
          objectFit: "cover",
          width: "100%",
          height: "100vh",
        }}
      />
    </VideoContainer>
  );
}
