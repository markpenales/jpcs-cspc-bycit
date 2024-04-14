<template>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <div :style='{ "background-image": "url(" + assets.background + ")", "min-height": "100vh", "min-width": "100vw", "background-size": "cover" }'
        class="text-white text-center">

        <Head title="Scanner List" />

        <h1 class="mb-5">Useful Links</h1>
        <div class="container">
            <div v-for="link, name in links">
                <a :href="link" class="text-decoration-none text-white">

                    <div class="border-bottom border-top my-2 py-3">
                        {{ name.toUpperCase().replace(/_/g, ' ') }}

                    </div>
                </a>

            </div>

        </div>
    </div>

</template>
<script setup>
import { ref, onMounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    assets: {
        type: Object,
        required: true,
    },
    links: {
        type: Object,
        required: true,
    }
})


</script>