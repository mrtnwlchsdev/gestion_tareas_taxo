// Api para realizar peticiones de tipo POST o GET
import axios from 'axios';
import config from '@/config/config';

const api = {
    // Función para realizar peticiones de tipo POST
    post: async (route, data) => {
        try {
            const response = await axios.post(`${config.api.url}${route}`, data);
            return response;
        } catch (error) {
            return error.response;
        }
    },
    // Función para realizar peticiones de tipo PUT
    put: async (route, data) => {
        try {
            const response = await axios.put(`${config.api.url}${route}`, data);
            return response;
        } catch (error) {
            return error.response;
        }
    },
    // Función para realizar peticiones de tipo GET
    get: async (route) => {
        try {
            const response = await axios.get(`${config.api.url}${route}`);
            return response.data;
        } catch (error) {
            return error.response;
        }
    }
}

export default api;
