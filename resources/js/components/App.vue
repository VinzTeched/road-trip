<template>
    <div>
        <h1 class="text-2xl font-bold text-center">
            Welcome to Travel Management App
        </h1>
        <MapComponent />
    </div>
</template>

<script>
import MapComponent from "./map/MapComponent.vue";

export default {
    components: {
        MapComponent,
    },
};
</script>

<style scoped></style>
