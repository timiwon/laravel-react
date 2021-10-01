import { listBusiness } from "../../apis/business"
import * as actions from "./actions"

export function getListBusiness({ status, type}) {
    return async function getListBusinessThunk(dispatch, getState) {
        dispatch(actions.getListRequested())
        try {
            const res = await listBusiness({ status, type});
            return dispatch(actions.getListSuccess(res))
        } catch (err) {
            dispatch(actions.getListFailed())
            throw new Error('Can\'t get list business')
        }
    }
}
