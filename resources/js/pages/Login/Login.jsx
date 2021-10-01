import React from "react"
import { connect } from "react-redux"
import { withRouter } from "react-router";
import { Typography, Alert, Badge, Form, Input, Row, Col, Card } from 'antd';

import { PATH } from "../../constants/paths"
import {
    style_right_box,
    style_left_box,
    style_left_box_wrapper,
    style_card_wrapper,
    style_card_header,
    style_text_left_box,
    CustomButton
} from "./Login.style"
import { login } from "../../stores/authen/thunks"

const mapStateToProps = state => ({
    loading: state.authen.loading
})

const mapDispatchToProps = {
    login
}

const connector = connect(mapStateToProps, mapDispatchToProps)

class Login extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            error: '',
            is_error: false,
        }
        this.onFinish = this.onFinish.bind(this)
        this.onFinishFailed = this.onFinishFailed.bind(this)
    }

    async onFinishFailed(err) {
        console.log(err)
    }

    async onFinish(values) {
        const { loading, login, history } = this.props

        if (!loading) {
            try {
                await login(values);
                history.push(PATH.HOME)
            } catch (err) {
                this.setState({
                    error: err.message,
                    is_error: true,
                })
            }
        }

        this.setState({ loading: true });
    }

    componentDidMount() {
        if (localStorage.getItem('token')) {
            this.props.history.push(PATH.HOME)
        }
    }

    render() {
        return (
            <div style={style_card_wrapper}>
                <Row type="flex" justify="center" align="middle" style={{ minHeight: '80vh' }}>
                    <Col>
                        <div style={style_left_box_wrapper} className="rotate_shadow_left">
                            <div style={style_left_box}>
                                <Typography.Title level={2} style={style_text_left_box}>Welcome</Typography.Title>
                            </div>
                        </div>
                    </Col>
                    <Col>
                        <Badge.Ribbon text="booking-sys" color="green">
                            <Card
                                title={<Typography.Title level={2}>Login</Typography.Title>}
                                className="rotate_shadow_right"
                                headStyle={style_card_header}
                                style={style_right_box}>
                                <Form
                                    name="basic"
                                    labelCol={{ span: 8 }}
                                    wrapperCol={{ span: 16 }}
                                    onFinish={this.onFinish}
                                    onFinishFailed={this.onFinishFailed}
                                    autoComplete="off"
                                >
                                    <Form.Item
                                        label="Email"
                                        name="email"
                                        rules={[{ required: true, message: 'Please input your email!', type: 'email' }]}
                                    >
                                        <Input />
                                    </Form.Item>

                                    <Form.Item
                                        label="Password"
                                        name="password"
                                        rules={[{ required: true, message: 'Please input your password!' }]}
                                    >
                                        <Input.Password />
                                    </Form.Item>

                                    <Form.Item wrapperCol={{ offset: 8, span: 16 }}>
                                        <CustomButton
                                            type="primary"
                                            htmlType="submit">
                                            Submit
                                        </CustomButton>
                                    </Form.Item>
                                </Form>
                                {this.state.is_error && (<Alert
                                    message={this.state.error}
                                    banner
                                    type="error"
                                />)}
                            </Card>
                        </Badge.Ribbon>
                    </Col>
                </Row>
            </div>
        );
    }
}

export default connector(withRouter(Login))
