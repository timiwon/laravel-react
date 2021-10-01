import * as types from "./constants"

export const getListRequested = () => ({
  type: types.GET_LIST_REQUESTED
})

export const getListSuccess = (payload) => ({
  type: types.GET_LIST_SUCCESS,
  payload
})

export const getListFailed = () => ({
  type: types.GET_LIST_FAILED
})
