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

    <Head title="Registration Closed" />

    <div :style='{ "background-image": "url(" + assets.background + ")", "min-height": "100vh", "min-width": "100vw", "background-size": "cover" }'
        class="font-small-caps">

        <div class="container">
            <div class="d-flex mx-0 justify-content-center align-items-center row w-100" style="height: 90vh;">
                <div class="d-flex mx-0 justify-content-center align-items-center row w-100" style="height: 90vh;">
                    <div>
                        <div class="row text-white">

                            <div class="fs-3 col-md-8 mx-auto">
                                Registration Closed.
                            </div>
                            <div class=" col-md-8 mx-auto">
                                If you have any concerns, please message our <a
                                    href="https://www.facebook.com/jpcscspc">page</a>.
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<style>
.font-small-caps {
    font-family: 'Montserrat', sans-serif;
}
</style>
