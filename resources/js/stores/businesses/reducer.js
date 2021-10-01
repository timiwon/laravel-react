import produce from "immer"

import * as types from "./constants"

const initialState = {
    loading: false,
    list: [],
    meta: {}
}

export const reducer = (state = initialState, action) =>
    produce(state, draft => {
        switch (action.type) {
            case types.GET_LIST_REQUESTED:
                draft.loading = true
                draft.meta = {}
                break
            case types.GET_LIST_SUCCESS:
                draft.loading = false
                draft.list = action.payload.data.data
                draft.meta = action.payload.data.meta
                break
            case types.GET_LIST_FAILED:
                draft.loading = false
                draft.list = []
                draft.meta = {}
                break
            default:
                return state
        }
    })
