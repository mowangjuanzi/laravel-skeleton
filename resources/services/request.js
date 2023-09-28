import axios from "axios";

const request = axios.create({
    timeout: 10000,
    headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer',
    },
})

export {request as request};
