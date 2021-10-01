import { logoutApi } from "../../apis/user"
import * as actions from "./actions"

export function logout() {
    return async function logoutThunk(dispatch, getState) {
        try {
            const res = await logoutApi();
        } catch (err) {
            // do nothing
        }
        dispatch(actions.logout())
        return true
    }
}
