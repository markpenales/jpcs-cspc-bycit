<script setup>
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, watch } from 'vue';

const getSectionData = (program, year) => {
    return axios.get(`api/sections/${program}/${year}`).then(response => {
        return response.data
    })
}

const props = defineProps({
    'login': {
        type: String,
        required: true,
    },
    'user': {
        required: false,
    },
    'colleges': {
        required: true,
    },
    'programs': {
        required: true,
    },
    'years': {
        required: true,
    }
})

const lastName = props.user?.last_name ?? null;
const firstName = props.user?.first_name ?? null;
const middleInitial = props.user?.middle_initial ?? null;
const sectionData = ref([]);
const college = '';
const program = ref('');
const year = ref('');
const section = '';

watch(year, async () => {
    if (year.value && program.value) {
        sectionData.value = await getSectionData(program.value, year.value)
    }
})
watch(program, async () => {
    if (year.value && program.value) {
        sectionData.value = await getSectionData(program.value, year.value)
    }
})

</script>

<template>
    <Head title="Begin Your Journey" />
    <div>
        <div v-if="user === null">
            <a :href="login">Begin Journey</a>
        </div>

        <div v-else>
            <form method="post">
                <input type="text" v-model="lastName">
                <input type="text" v-model="firstName">
                <input type="text" v-model="middleInitial">

                <select v-model="college">
                    <option value="" disabled selected>Select College</option>
                    <option v-for="college in colleges" :value="college.id">{{ college.name }}</option>
                </select>

                <select v-model="program">
                    <option value="" disabled selected>Select Program</option>
                    <option v-for="program in programs" :value="program.id">{{ program.name }}</option>
                </select>

                <select v-model="year">
                    <option value="" disabled selected>Select Year</option>
                    <option v-for="year in years" :value="year.id">{{ year.name }}</option>
                </select>

                <select v-model="section">
                    <option value="" disabled selected>Select Section</option>
                    <option v-for="section in sectionData.data" :value="section.id">{{ section.section }}</option>
                </select>
            </form>
        </div>
    </div>
</template>
