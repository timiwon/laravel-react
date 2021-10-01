import * as types from "./constants";
import produce from "immer";

const initialState = {
  loading: false
};

export const reducer = (state = initialState, action) =>
  produce(state, draft => {
    switch (action.type) {
      case types.LOGIN_REQUESTED:
        draft.loading = true
        break
      case types.LOGIN_SUCCESS:
        draft.loading = false
        break
      case types.LOGIN_FAILED:
        draft.loading = false
        break
      default:
        return state
    }
  });
