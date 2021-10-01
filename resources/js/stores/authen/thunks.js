import { loginApi } from "../../apis/user"
import * as actions from "./actions"

export function login(payload) {
    return async function loginThunk(dispatch, getState) {
        dispatch(actions.loginRequested())
        try {
            const res = await loginApi(payload);
            localStorage.setItem("token", res.data.access_token)
            return dispatch(actions.loginSuccess(res))
        } catch (err) {
            dispatch(actions.loginFailed(err))
            throw err
        }
    }
}
