import {request} from "../services/request.js";

export function registerApi(data) {
    return request.post('/api/session/register', data);
}

export function loginApi(data) {
    return request.post('/api/session/login', data);
}
