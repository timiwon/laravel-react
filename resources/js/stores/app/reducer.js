import produce from "immer"

import * as types from "./constants"
import { LOGIN_SUCCESS } from "../authen/constants"

const initialState = {
    isAuthenticated: false,
    closeSideNav: false,
    canGoBack: false,
}

export const reducer = (state = initialState, action) =>
    produce(state, draft => {
        switch (action.type) {
            case types.LOGOUT:
                localStorage.removeItem("token")
                draft.isAuthenticated = false
                break
            case LOGIN_SUCCESS:
                draft.isAuthenticated = true
                break
            case types.CLOSE_SIDE_NAV:
                draft.closeSideNav = !state.closeSideNav
                break
            case types.SET_GO_BACK:
                draft.canGoBack = action.payload
                break
            default:
                return state
        }
    })
