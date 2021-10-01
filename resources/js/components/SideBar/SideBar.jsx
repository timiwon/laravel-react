import React from "react"
import {
    Col,
    Row,
    Calendar,
    Timeline,
    Tabs,
    Spin,
    TimePicker,
    Drawer,
    Button,
    Typography,
    Form,
    Space,
    Select,
    Comment,
    Tooltip,
    Avatar,
    List,
    Input,
} from "antd"
import {
    CarryOutOutlined,
    TeamOutlined,
    PhoneOutlined,
    MailOutlined,
    ScheduleOutlined
} from "@ant-design/icons"
import moment from 'moment';

class SideBar extends React.Component {
    constructor(props) {
        super(props)
        this.state = {
            loading: false,
            visibleBookingDetail: false
        }
        this.timePickerChange = this.timePickerChange.bind(this)
        this.onCloseBookingDetail = this.onCloseBookingDetail.bind(this)
        this.showBookingDetail = this.showBookingDetail.bind(this)
        this.saveBookingDetail = this.saveBookingDetail.bind(this)
        this.tabChange = this.tabChange.bind(this)
    }

    onCloseBookingDetail() {
        this.setState({ visibleBookingDetail: false })
    }

    saveBookingDetail() {
        this.setState({ visibleBookingDetail: false })
    }

    showBookingDetail() {
        this.setState({ visibleBookingDetail: true })
    }

    timePickerChange(time, timeString) {
        console.log(time, timeString);
    }

    tabChange(key) {
        const self = this
        self.setState({ loading: true })
        console.log('---key: ', key)
        setTimeout(function () {
            self.setState({ loading: false })
        }, 500)
    }

    render() {
        const { visibleBookingDetail } = this.state
        const data = [{
            author: 'Admin',
            avatar: (<Avatar style={{ color: '#f56a00', backgroundColor: '#fde3cf' }}>
                'Admin'
            </Avatar>),
            content: (<p>We gotted.</p>),
            datetime: (
                <Tooltip title={moment().subtract(1, 'days').format('YYYY-MM-DD HH:mm:ss')}>
                    <span>{moment().subtract(1, 'days').fromNow()}</span>
                </Tooltip>
            ),
        }, {
            author: 'Guest',
            avatar: (<Avatar style={{ color: '#f56a00', backgroundColor: '#fde3cf' }}>
                'Guest'
            </Avatar>),
            content: (<p>with 2 childrens.</p>),
            datetime: (
                <Tooltip title={moment().subtract(2, 'days').format('YYYY-MM-DD HH:mm:ss')}>
                    <span>{moment().subtract(2, 'days').fromNow()}</span>
                </Tooltip>
            ),
        }];
        return (
            <div>
                <TimePicker onChange={this.timePickerChange} defaultValue={moment('00:00:00', 'HH:mm:ss')} />
                <Calendar fullscreen={false} className="side-calendar-card" />
                <Spin spinning={this.state.loading}>
                    <Tabs defaultActiveKey="1" onChange={this.tabChange}>
                        <Tabs.TabPane tab="Area 1" key="1">
                            <Timeline mode="left">
                                <Timeline.Item label="2015-09-01 09:12:11" color="green">
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest 3 (Table ...)</span>
                                    </div>
                                </Timeline.Item>
                                <Timeline.Item label="2015-09-01 09:30:00" color="green">
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest (8) (Table ...)</span>
                                    </div>
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest (6) (Table ...)</span>
                                    </div>
                                </Timeline.Item>
                                <Timeline.Item label="2015-09-01 10:10:11" color="green">
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest (6) (Table ...)</span>
                                    </div>
                                </Timeline.Item>
                                <Timeline.Item label="2015-09-01 11:00:00" color="green">
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest (12) (Table ...)</span>
                                    </div>
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest (16) (Table ...)</span>
                                    </div>
                                </Timeline.Item>
                                <Timeline.Item label="2015-09-01 11:12:11" color="green">
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest (4) (Table ...)</span>
                                    </div>
                                </Timeline.Item>
                            </Timeline>
                        </Tabs.TabPane>
                        <Tabs.TabPane tab="Area 2" key="2">
                            <Timeline mode="left">
                                <Timeline.Item label="2015-09-01 18:12:11" color="green">
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest (16) (Table ...)</span>
                                    </div>
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest (16) (Table ...)</span>
                                    </div>
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest (16) (Table ...)</span>
                                    </div>
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest (16) (Table ...)</span>
                                    </div>
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest (16) (Table ...)</span>
                                    </div>
                                    <div>
                                        <Button
                                            icon={<CarryOutOutlined />}
                                            type="primary"
                                            onClick={this.showBookingDetail} />
                                        <span>Guest (16) (Table ...)</span>
                                    </div>
                                </Timeline.Item>
                            </Timeline>
                        </Tabs.TabPane>
                    </Tabs>
                </Spin>
                <Drawer
                    className="drawer-sider-bar"
                    width={480}
                    bodyStyle={{ paddingBottom: 80, paddingTop: 15 }}
                    title="Booking Detail"
                    placement="right"
                    closable
                    visible={visibleBookingDetail}
                    onClose={this.onCloseBookingDetail}
                    key="booking_detail_id"
                    >
                    <Form
                        initialValues={{
                            ["status"]: "accepted",
                            ["duration"]: moment('00:00:00', 'HH:mm:ss'),
                        }}
                        labelCol={{ span: 8 }}
                        wrapperCol={{ span: 16 }}
                        style={{paddingBottom: 30}}
                        hideRequiredMark>
                        <Row gutter={16}>
                            <Col span={12}>
                                <Typography><h1>Guest Name</h1></Typography>
                            </Col>
                        </Row>
                        <Row gutter={16}>
                            <Col span={2}>
                                <ScheduleOutlined className="icon-1" style={{color: "#faad14"}}/>
                            </Col>
                            <Col span={12}>
                                <Typography>2021-19-09 10:30:00</Typography>
                            </Col>
                        </Row>
                        <Row gutter={16}>
                            <Col span={2}>
                                <TeamOutlined className="icon-1" style={{color: "#fadb14"}}/>
                            </Col>
                            <Col span={12}>
                                <Typography>16</Typography>
                            </Col>
                        </Row>
                        <Row gutter={16}>
                            <Col span={2}>
                                <PhoneOutlined className="icon-1" style={{color: "#08979c"}}/>
                            </Col>
                            <Col span={12}>
                                <Typography>0909999999</Typography>
                            </Col>
                        </Row>
                        <Row gutter={16}>
                            <Col span={2}>
                                <MailOutlined className="icon-1" style={{color: "#cf1322"}}/>
                            </Col>
                            <Col span={12}>
                                <Typography>guests@gmail.com</Typography>
                            </Col>
                        </Row>
                        <Row gutter={16} style={{marginTop: "15px"}}>
                            <Col span={12}>
                                <Form.Item
                                    name="status"
                                    label="Status"
                                    rules={[{ required: true, message: 'Please select status' }]}
                                >
                                    <Select>
                                        <Select.Option value="accepted">Accepted</Select.Option>
                                        <Select.Option value="seated">Seated</Select.Option>
                                        <Select.Option value="cancelled">Cancelled</Select.Option>
                                    </Select>
                                </Form.Item>
                            </Col>
                            <Col span={12}>
                                <Form.Item
                                    name="duration"
                                    label="Duration"
                                    rules={[{ required: true, message: 'Please choose duration' }]}
                                >
                                    <TimePicker onChange={this.timePickerChange} />
                                </Form.Item>
                            </Col>
                        </Row>
                        <Row gutter={16}>
                            <Col span={2} offset={20}>
                                <Space>
                                    <Button
                                        onClick={this.saveBookingDetail}
                                        type="primary">
                                        Save
                                    </Button>
                                </Space>
                            </Col>
                        </Row>
                    </Form>
                    <Row>
                        <Col span={24}>
                            <Comment
                                author='admin'
                                avatar={
                                    <Avatar style={{ color: '#f56a00', backgroundColor: '#fde3cf' }}>
                                        'Admin'
                                    </Avatar>
                                }
                                content={
                                    <Form>
                                        <Form.Item style={{marginBottom: 10}}>
                                            <Input.TextArea rows={4} />
                                        </Form.Item>
                                        <Form.Item>
                                            <Button htmlType="submit" type="primary">
                                                Reply
                                            </Button>
                                        </Form.Item>
                                    </Form>
                                } />
                            <List
                                dataSource={data}
                                itemLayout="horizontal"
                                renderItem={item => (
                                    <li>
                                        <Comment
                                            author={item.author}
                                            avatar={item.avatar}
                                            content={item.content}
                                            datetime={item.datetime}
                                        />
                                    </li>
                                )} />
                        </Col>
                    </Row>
                </Drawer>
            </div>
        )
    }
}

export default SideBar;
