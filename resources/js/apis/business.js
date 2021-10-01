import { get } from "./adapter.xhr"

export async function listBusiness ({ status, type}) {
    try {
        const res = await get(
            '/customers/9c87b02c-d917-49c2-bc28-5dcb1e12f062/businesses',
            { status, type }
        );
        return res;
    } catch (err) {
        throw new Error("something wrong")
    }
}
