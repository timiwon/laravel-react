import React from "react"
import { connect } from "react-redux"
import { NavLink as RRNavLink } from "react-router-dom"
import { withRouter } from "react-router"
import {
    Navbar,
    NavbarToggler,
    NavbarBrand,
    Collapse,
    Nav,
    NavItem,
    NavLink,
    UncontrolledDropdown,
    DropdownToggle,
    DropdownMenu,
    DropdownItem,
    Row,
} from "reactstrap"

import { PATH } from "../../constants/paths"
import { toggleSideNav } from "../../stores/app/actions"
import { logout } from "../../stores/app/thunks"
import { LogoutIcon, navbar_toggler } from "./Header.style"

const mapStateToProps = state => ({
  closeSideNav: state.app.closeSideNav
})

const mapDispatchToProps = {
  logout,
  toggleSideNav
}

const connector = connect(mapStateToProps, mapDispatchToProps)

class Header extends React.Component {
    constructor(props) {
        super(props)
        this.handleLogout = this.handleLogout.bind(this)
    }

    async handleLogout() {
        await this.props.logout()
        this.props.history.push(PATH.LOGIN)
    }

    componentDidMount() {
        if (!localStorage.getItem('token')) {
            this.props.history.push(PATH.LOGIN)
        }
    }

    render() {
        const { toggleSideNav, closeSideNav } = this.props
        return (
            <Row>
                <Navbar color="dark" dark expand="md">
                    <NavbarBrand href={PATH.BASE}>BOOKING SYS</NavbarBrand>
                    <NavbarToggler onClick={toggleSideNav} style={navbar_toggler} />
                    <Collapse isOpen={closeSideNav} navbar>
                        <Nav className="mr-auto" navbar>
                            <NavItem>
                                <NavLink tag={RRNavLink} exact to={PATH.HOME}>
                                    Home
                                </NavLink>
                            </NavItem>
                            <UncontrolledDropdown nav inNavbar>
                                <DropdownToggle nav caret>
                                    Options
                                </DropdownToggle>
                                <DropdownMenu right>
                                    <DropdownItem>
                                        Option 1
                                    </DropdownItem>
                                    <DropdownItem>
                                        Option 2
                                    </DropdownItem>
                                    <DropdownItem divider />
                                    <DropdownItem>
                                        Reset
                                    </DropdownItem>
                                </DropdownMenu>
                            </UncontrolledDropdown>
                        </Nav>
                        <LogoutIcon onClick={this.handleLogout} className="btn btn-outline-secondary">
                            Logout
                        </LogoutIcon>
                    </Collapse>
                </Navbar>
            </Row>
        )
    }
}

export default connector(withRouter(Header))
