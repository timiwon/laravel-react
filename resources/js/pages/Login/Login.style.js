import styled from "styled-components"
import Background from '../../assets/images/Tofu.jpeg';
import { Button } from "antd";

/*backgroundColor: "#52c41a",
borderColor: "#52c41a",
"&:hover": {
    background: "green"
}*/
export const CustomButton = styled(Button)`
    background: #52c41a !important;
    border-color: #52c41a !important;

    &:hover {
        background: green !important;
        border-color: green !important;
    }
`

export const Title = styled.h1`
  margin-bottom: 1rem;
  text-align: center;
`

export const style_card_header = {
  marginBottom: '1rem',
  textAlign: 'center',
}

export const style_card_wrapper = {
  padding: '30px',
}

export const style_left_box_wrapper = {
    backgroundImage: `url(${Background})`,
    backgroundRepeat: "no-repeat",
    backgroundSize: "460px",
    backgroundPositionX: "center",
    borderTopLeftRadius: "10px",
    borderBottomLeftRadius: "10px",
}

export const style_left_box = {
    textAlign: "center",
    backgroundColor: "rgba(124, 179, 5, 0.6)",
    padding: "40px 10px",
    minHeight: "307px",
    minWidth:"200px",
}

export const style_text_left_box = {
    color: "white",
}

export const style_right_box = {
    borderTopRightRadius: "10px",
    borderBottomRightRadius: "10px",
}
