<script setup>
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps({
    assets: {
        type: Object,
        required: true,
    },

    login: {
        type: String,
        required: true,
    }
})

const isDesktop = ref(true)
const handleResize = () => {
    isDesktop.value = window.innerWidth >= 992;
};

onMounted(() => {
    handleResize()
})
</script>

<template>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <Head title="Begin Your Journey" />

    <div :style='{ "background-image": "url(" + assets.background + ")", "min-height": "100vh", "min-width": "100vw", "background-size": "cover" }'
        class="font-small-caps">
        <div class="d-flex justify-content-center align-items-center row w-100" style="height: 100vh;">
            <div>
                <div>
                    <div :class="{ 'd-flex': true, 'justify-content-center': true }">
                        <img :src="assets.bycit_logo" width="600">
                    </div>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <a :href="login" class="btn rounded-pill fw-bold text-white px-4"
                        style="background-color: #A10075;">Begin
                        Journey</a>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.font-small-caps {
    font-variant: small-caps;
    text-transform: lowercase;
}
</style>
