<script setup>
import { Head, router } from '@inertiajs/vue3';
import { Button, Modal, message } from 'ant-design-vue';
import axios from 'axios';
import { defineProps, onMounted, onUnmounted, ref, watch } from 'vue';
const props = defineProps({
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
        type: Object,
        required: true
    },
    'restrictions': {
        type: Object,
        required: true
    }
})

const lastName = ref(props.user?.last_name ?? '');
const firstName = ref(props.user?.first_name ?? '');
const middleInitial = ref(props.user?.middle_initial ?? '');
const college = ref(props.user?.college_id ?? '');
const nickname = ref(props.user?.nickname ?? '');
const program = ref(props.user?.section?.program_id ?? '');
const year = ref(props.user?.section?.year_id ?? '');
const section = ref(props.user?.section_id ?? '');
const tshirt = ref(props.user?.t_shirt_size_id ?? '');
const suffix = ref(props.user?.suffix ?? '');
const dietaryRestrictions = ref(props.user?.dietary_restrictions ?? '');
const sectionData = ref([]);
const errors = ref([])
const isDesktop = ref(true)
const showProgramAndSection = ref(false);
const submitted = ref(false);
const isHovered = ref(false);
const tShirtGuideVisibility = ref(false);
const checkInfo = ref(false);
const confirm = ref(false);
const isRegistered = ref(!!(props.user?.registration) ?? false)

const showTShirtModal = () => {
    tShirtGuideVisibility.value = true;
};

const handleShirtModalOkay = () => {
    tShirtGuideVisibility.value = false;
};

const handleShirtModalCancel = () => {
    tShirtGuideVisibility.value = false;
};

const fetchData = () => {
    if (year.value && program.value) {
        sectionData.value = props.sections
            .filter(section => section.program_id === program.value && section.year_id === year.value)
            .map(({ id, section }) => ({ id, section }));
    }
};

const find = (object, value, returnKey = "name") => {
    try {
        return object.find(obj => obj.id == value)[returnKey]
    }

    catch {
        return ''
    }
}

const submit = async () => {
    submitted.value = true;
    checkInfo.value = false;
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
        user: props.user.id,
        confirm: confirm.value,
        restrictions: props.restrictions,
    }).then(response => {
        message.success(response.data.data.message + "\nYou will be logged out in 5 seconds", 5, () => {
            router.post('/logout');
        })
    }).catch(error => {
        errors.value = error.response.data.errors;
        message.error("Error: " + error.response.data.message)
        submitted.value = false
    })
}

const logout = () => {
    router.post('/logout')
}

const handleResize = () => {
    isDesktop.value = window.innerWidth >= 992;
};

const getFullName = () => {
    return lastName.value + (suffix.value ? ' ' + suffixes.find(suf => suf.id == suffix).name : '') + ', ' + (firstName.value) + (' ' + middleInitial.value + '.')
}

watch([year, program], fetchData, { deep: true });
watch(college, () => {
    if (college.value == 1) {
        showProgramAndSection.value = true;
    }
    else {
        showProgramAndSection.value = false;
    }
})

onMounted(() => {
    handleResize();
    window.addEventListener('resize', handleResize);
    showProgramAndSection.value = college.value == 1
    fetchData()
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
    showProgramAndSection.value = college.value == 1
    fetchData()
});
</script>

<template>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <Head title="Begin Your Journey" />

    <Modal v-model:open="isRegistered" :after-close="logout" title="This email is already registered" ok-text="Okay"
        ok-type="primary" cancel-text="Close" :ok-button-props="{ style: { display: 'none' } }" width="800px">
        This email is already associated with a registration. If you need to edit your registration, please send your
        concern to the
        <a href="https://www.facebook.com/jpcscspc">JPCS Facebook Page</a>.
    </Modal>


    <div :style='{ "background-image": "url(" + assets.background + ")", "min-height": "100vh", "min-width": "100vw", "background-size": "cover" }'
        class="font-small-caps">

        <div class="row">

            <div class="col-lg-8 mx-auto mb-5">
                <div>
                    <div
                        :class="{ 'd-flex': true, 'justify-content-end': isDesktop, 'mt-5': true, 'justify-content-center': !isDesktop }">
                        <img :src="assets.bycit_logo" alt="" :width="{ 300: isDesktop, 500: !isDesktop }">
                    </div>
                    <div class="justify-content-start text-white fw-bold fst-italic fs-3 ms-3">
                        <span>
                            Registration
                        </span>
                    </div>

                    <div class="row bg-white p-3 mx-3 border-0 rounded" id="form">

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
                                        <option value="" selected>Suffix (Optional)</option>
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
                                    <div class="d-flex gap-1 align-items-center">
                                        <select v-model="tshirt"
                                            :class="{ 'border-danger': errors.tshirt, 'font-small-caps': true, 'form-select': true }">
                                            <option value="" disabled selected>Select T-Shirt Size</option>
                                            <option v-for="size in sizes" :value="size.id">{{ size.name }}</option>
                                        </select>

                                        <div @click="tShirtGuideVisibility = !tShirtGuideVisibility">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" width="30" class="" role="button">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                            </svg>
                                        </div>
                                    </div>


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

                            <div v-if="showProgramAndSection" class="row">
                                <div class="col-lg-4 mt-1">
                                    <select v-model="program"
                                        :class="{ 'border-danger': errors.program, 'font-small-caps': true, 'form-select': true }">
                                        <option value="" disabled selected>Select Program</option>
                                        <option v-for="program in programs" :value="program.id">{{ program.name }}
                                        </option>
                                    </select>

                                    <span v-if="errors.program" class="text-danger">{{ errors.program[0] }}</span>
                                </div>

                                <div class="col-lg-4 mt-1">
                                    <select v-model="year"
                                        :class="{ 'border-danger': errors.year, 'font-small-caps': true, 'form-select': true }">
                                        <option value="" disabled selected>Select Year</option>
                                        <option v-for="year in years" :value="year.id">{{ year.name }}</option>
                                    </select>

                                    <span v-if="errors.year" class="text-danger">{{ errors.year[0] }}</span>
                                </div>

                                <div class="col-lg-4 mt-1">
                                    <select v-model="section"
                                        :class="{ 'border-danger': errors.section, 'font-small-caps': true, 'form-select': true }">
                                        <option value="" disabled selected>Select Section</option>
                                        <option v-for="s in sectionData" :value="s.id">{{ s.section }}</option>
                                    </select>
                                    <span v-if="errors.section" class="text-danger">{{ errors.section[0] }}</span>
                                </div>

                            </div>


                            <div class="mt-1 d-flex justify-content-center">
                                <div style="border: 1px solid #A10075;" class="px-1">
                                    <div class="text-center">Dietary Restrictions (Optional)</div>
                                    <div class="row">
                                        <div v-for="(res, index) in restrictions" :key="index" class="col-md-6">
                                            <div class="d-flex gap-3">
                                                <input type="checkbox" class="form-check-input" :id="res.name"
                                                    v-model="res.checked">
                                                <label :for="res.name">{{ res.name }}</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="mt-1">

                                <div v-if="restrictions.some(res => res.name === 'Allergies' && res.checked)" class="row">
                                    <div class="d-flex gap-1">
                                        <input type="text" placeholder="Allergies"
                                            v-model="restrictions.find(res => res.name === 'Allergies').allergy"
                                            :class="[{ 'col-8 form-control font-small-caps border-0': true, 'border-danger': errors['restrictions.3.allergy'] }]"
                                            :style="{ 'border-bottom': '1px solid ' + (errors['restrictions.3.allergy'] ? '#' : '#A10075') + ' !important' }">

                                    </div>
                                    <span v-if="errors['restrictions.3.allergy']" class="text-danger">Please enter your
                                        allergies</span>
                                </div>

                            </div>
                            <div class="mt-1">
                                <div class="d-flex gap-1">
                                    <input type="checkbox" class="form-check-input" v-model="confirm" id="confirm">
                                    <label for="confirm" style="text-transform: none;">
                                        I confirm that the information I provided is true and correct.
                                    </label>
                                </div>
                                <span v-if="errors.confirm" class="text-danger">{{ errors.confirm[0] }}</span>
                            </div>

                            <div class="d-flex justify-content-center align-items-center">
                                <button type="button" class="btn text-white w-50 fw-bold mt-1"
                                    style="background-color: #A10075;" @click="checkInfo = true"
                                    :disabled="submitted">Confirm</button>
                            </div>

                        </form>
                        <div>
                            <Modal v-model:open="tShirtGuideVisibility" @ok="handleShirtModalOkay" ok-text="Okay"
                                ok-type="primary" :cancel-button-props="{ style: { display: 'none' } }"
                                :ok-button-props="{ style: { display: 'none' } }" width="800px">
                                <img :src="assets.shirt_guide" alt="" class="border-0 rounded">
                            </Modal>
                        </div>
                        <div>
                            <Modal v-model:open="checkInfo" @ok="submit" title="Please check your information."
                                ok-text="Confirm" ok-type="primary"
                                :cancel-button-props="{ class: { 'btn btn-outline-danger d-inline-flex align-items-center': true } }"
                                :ok-button-props="{ class: { 'btn btn-outline-success d-inline-flex align-items-center': true }, disabled: submitted }">
                                <div class="row">
                                    <span class="d-flex col-12 rounded-pill d-flex align-items-center form-group row">
                                        <label class="col-6">Full Name</label>
                                        <div class="col-6">
                                            <p class="rounded px-3 py-1 form-control" style="border: 2px solid purple">{{
                                                getFullName()
                                            }}</p>
                                        </div>

                                    </span>
                                    <span class="d-flex col-12 rounded-pill d-flex align-items-center form-group row">
                                        <label class="col-6">Nickname</label>
                                        <div class="col-6">
                                            <div class="d-flex justify-content-center text-danger">This will appear on your
                                                ID!</div>

                                            <p class="rounded px-3 py-1 form-control" style="border: 2px solid purple">
                                                {{ nickname }}
                                                <span v-if="!nickname" class="text-danger">*This field is required*</span>
                                            </p>

                                        </div>

                                    </span>
                                    <span class="d-flex col-12 rounded-pill d-flex align-items-center form-group row">
                                        <label class="col-6">T-Shirt Size</label>
                                        <div class="col-6">
                                            <p class="rounded px-3 py-1 form-control" style="border: 2px solid purple">
                                                {{ find(sizes, tshirt) }}
                                                <span v-if="!tshirt" class="text-danger">*This field is required*</span>
                                            </p>
                                        </div>

                                    </span>
                                    <span class="d-flex col-12 rounded-pill d-flex align-items-center form-group row">
                                        <label class="col-6">School</label>
                                        <div class="col-6">
                                            <p class="rounded px-3 py-1 form-control" style="border: 2px solid purple">
                                                {{ find(colleges, college) }}
                                                <span v-if="!college" class="text-danger">*This field is required*</span>
                                            </p>
                                        </div>


                                    </span>
                                    <span class="d-flex col-12 rounded-pill d-flex align-items-center form-group row"
                                        v-if="college == 1">
                                        <label class="col-6">
                                            Program and 4ection
                                        </label>
                                        <div class="col-6">
                                            <p class="rounded px-3 py-1 form-control" style="border: 2px solid purple">
                                                {{ find(programs, program, code) }} -
                                                {{ find(years, year) }}{{ find(sections, section, section) }}
                                                <span v-if="!section" class="text-danger">*This field is required*</span>

                                            </p>
                                        </div>


                                    </span>
                                    <span class="d-flex col-12 rounded-pill d-flex align-items-center form-group row">
                                        <label class="col-6">Dietary Restrictions</label>
                                        <div class="col-6">
                                            <p class="rounded px-3 py-1 form-control" style="border: 2px solid purple">
                                            <div
                                                v-for="restrict in restrictions.filter(res => res.checked === true).map(res => [res.name, res.allergy])">
                                                {{ restrict[0] }}{{ restrict[1] ? ': ' + restrict[1] : '' }}
                                            </div>

                                            <span v-if="!dietaryRestrictions" class="text-danger"></span>
                                            </p>

                                        </div>
                                    </span>
                                </div>
                            </Modal>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.font-small-caps {
    text-transform: capitalize !important;
    font-family: 'Montserrat', sans-serif !important;
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

select {
    font-family: 'Montserrat', sans-serif;
    text-transform: capitalize;
}

option {
    font-family: 'Montserrat', sans-serif;
    text-transform: capitalize;
}

::placeholder {
    font-family: 'Montserrat', sans-serif;
    text-transform: capitalize;
    text-align: center;
}
</style>

