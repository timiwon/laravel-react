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

import { PATH } from "../../constants/paths"
import MainLayout from "../../layouts/MainLayout"
import Carousel from "../../components/Carousel/Carousel"
import {setGoBack} from "../../stores/app/actions"

const mapStateToProps = state => ({
})

const mapDispatchToProps = dispatch => {
    return {
        setGoBack: (val) => dispatch(setGoBack(val))
    }
}

const connector = connect(mapStateToProps, mapDispatchToProps)

class Area extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            visible: false,
        }
        this.showDrawer = this.showDrawer.bind(this)
        this.onClose = this.onClose.bind(this)
        this.gotoFloorPlan = this.gotoFloorPlan.bind(this)
    }

    gotoFloorPlan() {
        this.props.history.push(PATH.FLOOR_PLAN)
    }

    showDrawer() {
        this.setState({visible: true})
    }

    onClose() {
        this.setState({visible: false})
    }

    componentDidMount() {
        this.props.setGoBack(true);
    }

    render() {
        const {visible} = this.state
        return (
            <MainLayout>
                <Row gutter={[16, 16]}>
                    <Col span={6}>
                        <Row>
                            <Col span={24}>
                                <div className="main-action-button-cell booking-button" onClick={this.showDrawer}>
                                    <span className="disable-select">Booking</span>
                                </div>
                            </Col>
                        </Row>
                    </Col>
                    <Col span={10}>
                        <Row gutter={[10, 10]}>
                            <Col span={24}>
                                <div className="main-action-button-cell tables-management-button" onClick={this.showDrawer}>
                                    <span className="disable-select">Tables Management</span>
                                </div>
                            </Col>
                        </Row>
                        <Row>
                            <Col span={24}>
                                <div className="main-action-button-cell list-areas-button floor-plan-button" onClick={this.gotoFloorPlan}>
                                    <span className="disable-select">Floor Plan</span>
                                </div>
                            </Col>
                        </Row>
                    </Col>
                    <Col span={8}>
                        <Row>
                            <Col span={24}>
                                <div className="main-action-button-cell info-button" onClick={this.showDrawer}>
                                    <span className="disable-select">Edit Info</span>
                                </div>
                            </Col>
                        </Row>
                        <Row>
                            <Col span={24}>
                                <div className="main-action-button-cell opening-times-button" onClick={this.showDrawer}>
                                </div>
                            </Col>
                        </Row>
                    </Col>
                </Row>
                <Row>
                    <Col>
                        <Carousel slidesToScroll={3} slidesToShow={3} narrow>
                            <Space align="baseline">
                                <Card className="custom-main-carousel-item active item1">
                                    <Badge.Ribbon text="business1" color="green">
                                        <div className="content">
                                            <h1>Area 1</h1>
                                        </div>
                                    </Badge.Ribbon>
                                </Card>
                            </Space>
                            <Space align="baseline">
                                <Card className="custom-main-carousel-item item2">
                                    <Badge.Ribbon text="business1" color="green">
                                        <div className="content">
                                            <h1>Area 2</h1>
                                        </div>
                                    </Badge.Ribbon>
                                </Card>
                            </Space>
                            <Space align="baseline">
                                <Card className="custom-main-carousel-item item3">
                                    <Badge.Ribbon text="business1" color="green">
                                        <div className="content">
                                            <h1>Area 3</h1>
                                        </div>
                                    </Badge.Ribbon>
                                </Card>
                            </Space>
                            <Space align="baseline">
                                <Card className="custom-main-carousel-item item2">
                                    <Badge.Ribbon text="business1" color="green">
                                        <div className="content">
                                            <h1>Area 4</h1>
                                        </div>
                                    </Badge.Ribbon>
                                </Card>
                            </Space>
                        </Carousel>
                    </Col>
                </Row>
                <Drawer
                    title="Manual Booking"
                    placement="left"
                    width={400}
                    onClose={this.onClose}
                    visible={visible}
                    extra={
                        <Space>
                            <Button onClick={this.onClose}>Cancel</Button>
                            <Button type="primary" onClick={this.onClose}>
                                OK
                            </Button>
                        </Space>
                    }
                >
                    <p>Some contents...</p>
                    <p>Some contents...</p>
                    <p>Some contents...</p>
                </Drawer>
            </MainLayout>
        )
    }
}

export default connector(withRouter(Area));
