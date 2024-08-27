<template>
    <div>
        <l-map
            style="height: 500px; width: 100%"
            :zoom="zoom"
            :center="center"
            @click="addMarker"
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
        addMarker(e) {
            const name = prompt("Enter a name for this destination:");
            if (name) {
                const newMarker = {
                    name,
                    latlng: e.latlng,
                };
                this.markers.push(newMarker);
                this.saveDestination(newMarker);
            }
        },
        async saveDestination(marker) {
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
