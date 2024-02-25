<script setup>
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { defineProps, ref, watch } from 'vue';

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
    },
    'sizes': {
        required: true
    }
})

const lastName = ref(props.user?.last_name ?? null);
const firstName = ref(props.user?.first_name ?? null);
const middleInitial = ref(props.user?.middle_initial ?? null);
const college = ref('');
const nickname = ref('');
const program = ref('');
const year = ref('');
const section = ref('');
const tshirt = ref('');
const dietaryRestrictions = ref('');
const sectionData = ref([]);

const fetchData = () => {
    if (year.value && program.value) {
        sectionData.value = props.sections
            .filter(section => section.program_id === program.value && section.year_id === year.value)
            .map(({ id, section }) => ({ id, section }));
    }
};

watch([year, program], fetchData, { deep: true });
</script>

<template>
    <Head title="Begin Your Journey" />
    <div>
        <div v-if="user === null">
            <a :href="login">Begin Journey</a>
        </div>

        <div v-else>
            <form method="post">
                <input type="text" v-model="lastName" placeholder="Last Name">
                <input type="text" v-model="firstName" placeholder="First Name">
                <input type="text" v-model="middleInitial" placeholder="Middle Initial">
                <input type="text" v-model="nickname" placeholder="Nickname">
                <select v-model="tshirt">
                    <option value="" disabled selected>Select T-Shirt Size</option>
                    <option v-for="size in sizes" :value="size.id">{{ size.name }}</option>
                </select>
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
                    <option v-for="s in sectionData" :value="s.id">{{ s.section }}</option>
                </select>

                <textarea v-model="dietaryRestrictions" cols="30" rows="10" placeholder="Dietary Restrictions"></textarea>

            </form>
        </div>
    </div>
</template>
