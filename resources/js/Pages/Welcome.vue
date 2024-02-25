<script setup>
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { guardReactiveProps } from 'vue';
import { ref, watch } from 'vue';

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
    },
    'sections': {
        required: true
    }
})

const lastName = props.user?.last_name ?? null;
const firstName = props.user?.first_name ?? null;
const middleInitial = props.user?.middle_initial ?? null;
const college = '';
const program = ref('');
const year = ref('');
const section = '';
var sectionData = [];


const fetchData = () => {
    if (year.value && program.value) {
        sectionData = props.sections
            .filter(section => section.program_id === program.value && section.year_id === year.value)
            .map(({ id, section }) => ({ id, section }));

    }
};

watch(year, fetchData, {deep: true});
watch(program, fetchData, {deep: true});
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
                    <option value="" disabled selected>Select Program and Year first</option>
                    <option v-for="s in sectionData" :value="s.id">{{ s.section }}</option>
                </select>

                {{ sectionData }}
            </form>
        </div>
    </div>
</template>
