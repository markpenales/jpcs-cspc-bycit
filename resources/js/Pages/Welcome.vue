<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    'login': {
        type: String,
        required: true,
    },
    'user': {
        required: false,
    }
})
</script>

<template>
    <Head title="Begin Your Journey"/>
<div>
    <a :href="login">Begin Journey</a>
</div>
</template>
