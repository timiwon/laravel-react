import React from "react"
import { Spin } from 'antd';

class Loading extends React.Component {
    render() {
        return <Spin tip="Loading..." style={{width: '100%', marginTop: 50}}></Spin>
    }
}

export default Loading;
