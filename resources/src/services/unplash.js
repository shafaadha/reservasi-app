import axios from "axios";
import api from "./api";

class UnsplashService {
    async accessKey() {
        const { data } = await api.get("/config");
        return data.unsplash_access_key;
    }

    async search(query, perPage = 12) {
        const key = await this.accessKey();

        const { data } = await axios.get(
            "https://api.unsplash.com/search/photos",
            {
                params: {
                    query,
                    per_page: perPage,
                },
                headers: {
                    Authorization: `Client-ID ${key}`,
                },
            },
        );

        return data.results;
    }
}

export default new UnsplashService();
