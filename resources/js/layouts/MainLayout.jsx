import React from "react"
import { withRouter } from "react-router"
import { connect } from "react-redux"
import {
    Avatar,
    Button,
    Col,
    Layout,
    Menu,
    Row,
    Typography,
    Dropdown
} from 'antd'
import {ArrowLeftOutlined} from '@ant-design/icons'

import { PATH } from '../constants/paths'
import SideBar from '../components/SideBar/SideBar'
import { logout } from '../stores/app/actions'

const { Header, Content } = Layout;

const mapStateToProps = state => ({
    canGoBack: state.app.canGoBack
})

const mapDispatchToProps = dispatch => {
    return {
        logout: () => dispatch(logout())
    }
}

const connector = connect(mapStateToProps, mapDispatchToProps)

class MainLayout extends React.Component {
    constructor(props) {
        super(props)
        this.goBack = this.goBack.bind(this)
        this.logout = this.logout.bind(this)
    }

    logout() {
        this.props.logout()
        this.props.history.push(PATH.LOGIN)
    }

    goBack() {
        this.props.history.goBack()
    }

    componentDidMount() {
        if (!localStorage.getItem('token')) {
            this.props.history.push(PATH.LOGIN)
        }
    }

    render() {
        const menu = (
            <Menu>
                <Menu.Item>
                    <div onClick={this.logout}>
                        Logout
                    </div>
                </Menu.Item>
            </Menu>
        );
        const {children} = this.props
        const display = this.props.canGoBack ? 'block' : 'none'
        return (
            <Layout>
                <Layout className="site-layout">
                    <Header className="header">
                        <Typography.Title className="logo">
                            Logo
                        </Typography.Title>
                        <Menu theme="dark" mode="horizontal" defaultSelectedKeys={['1']}>
                            <Menu.Item key="1">Features</Menu.Item>
                            <Menu.Item key="2">Report</Menu.Item>
                            <Menu.Item key="3">Accounts</Menu.Item>
                        </Menu>
                        <Dropdown overlay={menu} placement="bottomCenter">
                            <Avatar style={{
                                cursor: 'pointer',
                                color: '#f56a00',
                                backgroundColor: '#fde3cf',
                                display: 'flex',
                                top: -50,
                                left: '80%'}}>U</Avatar>
                        </Dropdown>
                    </Header>
                    <div style={{ minHeight: 32 }}>
                        <Button onClick={this.goBack}
                            style={{
                                display,
                                border: 'none',
                                backgroundColor: '#52c41a',
                                boxShadow: 'none',
                                left: -170,
                                borderTopRightRadius: 10,
                                borderBottomRightRadius: 10,
                                color: '#fff'
                            }}>
                            <ArrowLeftOutlined
                                style={{ verticalAlign: 'baseline' }} />
                            <span style={{ verticalAlign: 'text-top', marginLeft: 5 }}>Back</span>
                        </Button>
                    </div>
                    <Content className="site-layout-background">
                        <Row>
                            <Col>
                        {children}
                        </Col>
                        </Row>
                    </Content>
                </Layout>
                <aside
                    className="ant-layout-sider">
                    <div className="ant-layout-sider-children">
                        <SideBar />
                    </div>
                </aside>
            </Layout>
        );
    }
}

export default connector(withRouter(MainLayout));
