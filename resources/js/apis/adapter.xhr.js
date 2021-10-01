import Axios from "axios";

import { API_PATH } from '../constants/paths'

function axiosInstance() {
    const instance = Axios.create({
        baseURL: API_PATH.BASE_URL
    })

    if (localStorage.getItem('token')) {
        instance.defaults.headers['Authorization'] = `bearer ${localStorage.getItem('token')}`
    }

    return instance
}

export function get(url, params) {
    const axios = axiosInstance();
    return axios.get(url, { params });
}

export function post(url, requestData) {
    const axios = axiosInstance();
    return axios.post(url, requestData);
}
