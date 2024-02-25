<script setup>
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { defineProps, ref, watch, onMounted, onUnmounted } from 'vue';

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
    },
    'suffixes': {
        required: true
    },
    'assets': {
        type: String,
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
const suffix = ref('');
const dietaryRestrictions = ref('');
const sectionData = ref([]);
const errors = ref([])
const isDesktop = ref(true)
var showProgramAndSection = ref(false);

const fetchData = () => {
    if (year.value && program.value) {
        sectionData.value = props.sections
            .filter(section => section.program_id === program.value && section.year_id === year.value)
            .map(({ id, section }) => ({ id, section }));
    }
};

const submit = async () => {
    await axios.post('/api/register', {
        lastName: lastName.value,
        firstName: firstName.value,
        middleInitial: middleInitial.value,
        college: college.value,
        nickname: nickname.value,
        program: program.value,
        year: year.value,
        section: section.value,
        tshirt: tshirt.value,
        suffix: suffix.value,
        dietaryRestrictions: dietaryRestrictions.value,
    }).then(response => console.log(response)).catch(error => errors.value = error.response.data.errors)
}

const handleResize = () => {
    isDesktop.value = window.innerWidth >= 992;
};

watch([year, program], fetchData, { deep: true });
watch(college, () => {
    showProgramAndSection.value = true;
})

onMounted(() => {
    handleResize();
    window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
});
</script>

<template>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <Head title="Begin Your Journey" />

    <div :style='{ "background-image": "url(" + assets.background + ")", "min-height": "100vh", "min-width": "100vw", "background-size": "cover" }'
        class="font-small-caps">
        <div v-if="user === null" class="d-flex justify-content-center align-items-center row w-100" style="height: 100vh;">
            <div>
                <div>
                <div :class="{ 'd-flex': true, 'justify-content-center': true }">
                    <img :src="assets.bycit_logo" alt="" :width="{ 300: isDesktop, 500: !isDesktop }">
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <a :href="login" class="btn rounded-pill fw-bold text-white px-4" style="background-color: #A10075;">Begin Journey</a>

            </div>
            </div>
           
        </div>

        <div v-else class="row">
            <div class="col-lg-4 d-flex justify-content-center align-items-center mt-5 pt-5" id="mascot" v-if="isDesktop">
                <img :src="assets.mascot" alt="BYCIT Mascot" width="300">
            </div>
            <div class="col-lg-8">
                <div>
                    <div
                        :class="{ 'd-flex': true, 'justify-content-end': isDesktop, 'mt-5': true, 'justify-content-center': !isDesktop }">
                        <img :src="assets.bycit_logo" alt="" :width="{ 300: isDesktop, 500: !isDesktop }">
                    </div>
                    <div class="justify-content-start text-white fw-bold fst-italic fs-3 ms-5">
                        <span>
                            12th BYCIT Registration
                        </span>
                    </div>

                    <div class="row bg-white p-3 ms-5 me-5 border-0 rounded" id="form">
                        <div class="d-flex fw-bold">
                            <div>
                                <img :src=assets.circle alt="" width="50">
                            </div>
                            <span style="color: #C41696" class="fs-4 fst-italic">
                                Register
                            </span>
                        </div>
                        <form>

                            <div class="row mt-1">
                                <div class="col-lg-3 mt-1">
                                    <input type="text" v-model="lastName" placeholder="Last Name"
                                        :class="{ 'border-danger': errors.lastName, 'font-small-caps': true, 'form-control': true }">

                                    <span v-if="errors.lastName" class="text-danger">{{ errors.lastName[0] }}</span>

                                </div>
                                <div class="col-lg-3 mt-1">
                                    <input type="text" v-model="firstName" placeholder="First Name"
                                        :class="{ 'border-danger': errors.firstName, 'font-small-caps': true, 'form-control': true }">

                                    <span v-if="errors.firstName" class="text-danger">{{ errors.firstName[0] }}</span>

                                </div>


                                <div class="col-lg-3 mt-1">
                                    <input type="text" v-model="middleInitial" placeholder="Middle Initial"
                                        :class="{ 'border-danger': errors.middleInitial, 'font-small-caps': true, 'form-control': true }">

                                    <span v-if="errors.middleInitial" class="text-danger">{{ errors.middleInitial[0]
                                    }}</span>

                                </div>

                                <div class="col-lg-3 mt-1">
                                    <select v-model="suffix"
                                        :class="{ 'border-danger': errors.suffix, 'font-small-caps': true, 'form-select': true }">
                                        <option value="" disabled selected>Suffix (Optional)</option>
                                        <option v-for="suf in suffixes" :value="suf.id">{{ suf.name }}</option>
                                    </select>
                                    <span v-if="errors.suffix" class="text-danger">{{ errors.suffix[0] }}</span>

                                </div>

                            </div>
                            <div class="row mt-1">
                                <div class="col-lg-6 mt-1">
                                    <input type="text" v-model="nickname" placeholder="Nickname"
                                        :class="{ 'border-danger': errors.nickname, 'font-small-caps': true, 'form-control': true }">
                                    <span v-if="errors.nickname" class="text-danger">{{ errors.nickname[0] }}</span>

                                </div>


                                <div class="col-lg-6 mt-1">
                                    <select v-model="tshirt"
                                        :class="{ 'border-danger': errors.tshirt, 'font-small-caps': true, 'form-select': true }">
                                        <option value="" disabled selected>Select T-Shirt Size</option>
                                        <option v-for="size in sizes" :value="size.id">{{ size.name }}</option>
                                    </select>
                                    <span v-if="errors.tshirt" class="text-danger">{{ errors.tshirt[0] }}</span>

                                </div>

                            </div>
                            <div class="row mt-1">
                                <div class="col-12-lg">
                                    <select v-model="college"
                                        :class="{ 'border-danger': errors.college, 'font-small-caps': true, 'form-select': true }">
                                        <option value="" disabled selected>Select School</option>
                                        <option v-for="college in colleges" :value="college.id">{{ college.name }}</option>
                                    </select>
                                    <span v-if="errors.college" class="text-danger">{{ errors.college[0] }}</span>
                                </div>

                            </div>

                            <div v-if="showProgramAndSection" class="flex flex-wrap mt-1">
                                <div>
                                    <select v-model="program"
                                        :class="{ 'border-danger': errors.program, 'font-small-caps': true, 'form-select': true }">
                                        <option value="" disabled selected>Select Program</option>
                                        <option v-for="program in programs" :value="program.id">{{ program.name }}
                                        </option>
                                    </select>

                                    <span v-if="errors.program" class="text-danger">{{ errors.program[0] }}</span>
                                </div>

                                <div>
                                    <select v-model="year"
                                        :class="{ 'border-danger': errors.year, 'font-small-caps': true, 'form-select': true }">
                                        <option value="" disabled selected>Select Year</option>
                                        <option v-for="year in years" :value="year.id">{{ year.name }}</option>
                                    </select>

                                    <span v-if="errors.year" class="text-danger">{{ errors.year[0] }}</span>
                                </div>

                                <div>
                                    <select v-model="section"
                                        :class="{ 'border-danger': errors.section, 'font-small-caps': true, 'form-select': true }">
                                        <option value="" disabled selected>Select Section</option>
                                        <option v-for="s in sectionData" :value="s.id">{{ s.section }}</option>
                                    </select>
                                    <span v-if="errors.section" class="text-danger">{{ errors.section[0] }}</span>
                                </div>

                            </div>


                            <div class="mt-1">
                                <textarea v-model="dietaryRestrictions" cols="30" rows="10"
                                    placeholder="Dietary Restrictions"
                                    :class="{ 'border-danger': errors.dietaryRestrictions, 'font-small-caps': true, 'form-control': true }"></textarea>
                                <span v-if="errors.dietaryRestrictions" class="text-danger">{{ errors.dietaryRestrictions[0]
                                }}
                                    Restriction</span>

                            </div>

                            <div>
                                <button type="button" class="btn text-white w-100 fw-bold mt-1"
                                    style="background-color: #A10075;" @click="submit">Confirm</button>
                            </div>
                        </form>
                    </div>

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

#mascot {
    transform: scaleX(-1);
    -webkit-transform: scaleX(-1);
}

body {
    overflow-x: hidden;
}

#form {
    box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.7),
        0 0 4px rgb(255, 255, 255);
}

.form-control,
.form-select {
    border: 1px solid #A10075 !important;
    text-align: center;
}

::placeholder {
    text-align: center;
}
</style>

