import React, { Component } from "react";
import { Row, Col, Carousel } from "antd";
import {RightOutlined, LeftOutlined} from '@ant-design/icons';

export default class CarouselComponent extends Component {
    constructor(props) {
        super(props);
        this.next = this.next.bind(this);
        this.previous = this.previous.bind(this);
        this.carousel = React.createRef();
    }
    next() {
        this.carousel.next();
    }
    previous() {
        this.carousel.prev();
    }

    render() {
        const { children, slidesToScroll, slidesToShow } = this.props
        const showNumber = slidesToShow ? slidesToShow : 1
        const slideNumber = slidesToScroll ? slidesToScroll : 1
        const props = {
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: showNumber,
            slidesToScroll: slideNumber
        };
        if ('narrow' in this.props) {
            return (
                <Row className="carousel-wrapper">
                    <Col span={1}>
                        <LeftOutlined onClick={this.previous} />
                    </Col>
                    <Col span={22}>
                        <Carousel ref={node => (this.carousel = node)} {...props}>
                            {children}
                        </Carousel>
                    </Col>
                    <Col span={1}>
                        <RightOutlined onClick={this.next} />
                    </Col>
                </Row>
            );
        }

        return (
            <Row className="carousel-wrapper">
                <Col span={24}>
                    <Carousel ref={node => (this.carousel = node)} {...props}>
                        {children}
                    </Carousel>
                </Col>
            </Row>
        );
    }
}
