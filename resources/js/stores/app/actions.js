import * as types from "./constants"

export const logout = () => ({
  type: types.LOGOUT
})

export const toggleSideNav = () => ({
  type: types.CLOSE_SIDE_NAV
})

export const setGoBack = (payload) => ({
  type: types.SET_GO_BACK,
  payload
})
