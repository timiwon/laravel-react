import React from "react"
import { withRouter } from "react-router";
import { connect } from "react-redux"
import {
    Col,
    Row,
    Badge,
    Card,
    Space,
    Drawer,
    Button,
} from "antd"

import MainLayout from "../../layouts/MainLayout"
import {setGoBack} from "../../stores/app/actions"
// import FloorPlanPage from "../../assets/images/FloorPlanPage.jpg"
import Circle from "../../components/FloorPlan/Circle";
import Rectangle from "../../components/FloorPlan/Rectangle";

const mapStateToProps = state => ({
})

const mapDispatchToProps = dispatch => {
    return {
        setGoBack: (val) => dispatch(setGoBack(val))
    }
}

const connector = connect(mapStateToProps, mapDispatchToProps)

class FloorPlan extends React.Component {
    componentDidMount() {
        this.props.setGoBack(true);
    }

    render() {
        return (
            <MainLayout>
                <Row gutter={[16, 16]}>
                    <Col>
                        <svg viewBox="0 0 400 400" width="600" height="500"
                            style={{border: "1px solid black"}}>
                            <Circle />
                            <Rectangle />
                        </svg>
                    </Col>
                </Row>
            </MainLayout>
        )
    }
}

export default connector(withRouter(FloorPlan));
