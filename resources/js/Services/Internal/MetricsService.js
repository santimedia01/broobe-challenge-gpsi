import axios from 'axios';

export default class MetricsService {
    async run(url, strategy, categories= []) {
        const response = await axios.get('/api/v1/metrics/run', {
            params: {
                url,
                strategy,
                categories
            }
        });

        return response.data
    }

    async save(id) {
        const response = await axios.post('/api/v1/metrics/save/'+id)

        return response.data
    }
}
