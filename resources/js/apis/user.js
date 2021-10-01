import { post } from "./adapter.xhr"
import { API_PATH } from "../constants/paths"

export async function loginApi ({ email, password}) {
    try {
        const res = await post(API_PATH.LOGIN, { email, password });
        return res;
    } catch (err) {
        throw new Error("email or password was wrong")
    }
}

export async function logoutApi () {
    try {
        const res = await post(API_PATH.LOGOUT, {});
        return res;
    } catch (err) {
        return false;
    }
}
