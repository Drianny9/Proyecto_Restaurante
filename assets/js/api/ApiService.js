//====SERVICIO API CENTRALIZADO====
//Clase para centralizar todas las peticiones fetch a la API

class ApiService {
    constructor(baseUrl = 'api/') {
        this.baseUrl = baseUrl;
    }

    //GET genérico con parámetros opcionales
    async get(endpoint, params = {}) {
        let url = this.baseUrl + endpoint;

        //Construir query string con Object.entries + filter + map
        const queryParams = Object.entries(params)
            .filter(([, value]) => value !== undefined && value !== null)
            .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`)
            .join('&');

        if (queryParams) {
            url += '?' + queryParams;
        }

        const response = await fetch(url);
        return response.json();
    }

    //POST genérico
    async post(endpoint, data) {
        const response = await fetch(this.baseUrl + endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        return response.json();
    }

    //PUT genérico
    async put(endpoint, data) {
        const response = await fetch(this.baseUrl + endpoint, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        return response.json();
    }

    //DELETE genérico
    async delete(endpoint, id) {
        const response = await fetch(`${this.baseUrl}${endpoint}?id=${id}`, {
            method: 'DELETE'
        });
        return response.json();
    }
}

//Instancia global para que todos los módulos la usen
const api = new ApiService();
