<template>
    <div>
        <l-map
            style="height: 500px; width: 100%"
            :zoom="zoom"
            :center="center"
            @click="handleMapClick"
        >
            <l-tile-layer :url="url" :attribution="attribution" />
            <l-marker
                v-for="(marker, index) in markers"
                :key="index"
                :lat-lng="marker.latlng"
            >
                <l-popup>{{ marker.name }}</l-popup>
            </l-marker>
        </l-map>
    </div>
</template>

<script>
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";
import axios from "axios";

export default {
    components: {
        LMap,
        LTileLayer,
        LMarker,
        LPopup,
    },
    data() {
        return {
            zoom: 10,
            center: [51.505, -0.09], // Default center position (latitude, longitude)
            url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", // OpenStreetMap tiles
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            markers: [],
        };
    },
    methods: {
        async handleMapClick(e) {
            const latlng = e.latlng;
            try {
                const locationName = await this.getLocationName(
                    latlng.lat,
                    latlng.lng
                );
                const newMarker = {
                    name: locationName,
                    latlng,
                };
                this.markers.push(newMarker);
                this.saveDestination(newMarker);
            } catch (error) {
                console.error("Error getting location name:", error);
            }
        },
        async getLocationName(lat, lng) {
            const apiKey = "8198b9a1a7fa493aac8a52ceacee50c6"; // Replace with your API key if needed
            const url = `https://api.opencagedata.com/geocode/v1/json?q=${lat}+${lng}&key=${apiKey}`;

            const response = await axios.get(url);
            const result = response.data.results[0];

            if (result) {
                const components = result.components;
                const city =
                    components.city ||
                    components.town ||
                    components.village ||
                    components.hamlet ||
                    "Unknown city";
                const country = components.country || "Unknown country";
                return `${city}, ${country}`;
            } else {
                return "Unknown location";
            }
        },
        async saveDestination(marker) {
            console.log(marker.name);
            try {
                const response = await axios.post("/api/destinations", {
                    name: marker.name,
                    latitude: marker.latlng.lat,
                    longitude: marker.latlng.lng,
                    order: this.markers.length,
                });
                console.log("Destination saved:", response.data);
            } catch (error) {
                console.error("Error saving destination:", error);
            }
        },
    },
};
</script>

<style scoped></style>
