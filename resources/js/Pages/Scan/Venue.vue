<script setup>
import { Head } from "@inertiajs/vue3"
import { onMounted, ref, watch, h } from "vue"
import QrScanner from "qr-scanner";
import axios from "axios";
import { message, Modal } from "ant-design-vue";


const props = defineProps({
    venue: {
        type: String,
        required: true
    },
    list: {
        type: Object,
        default: {}
    },
    assets: {
        type: Object,
        required: true
    }
})

const selectedScanner = ref(null)
const registrationInfoModalVisible = ref(false)
const registrationInfo = ref(null)
let qrScanner = null

watch(selectedScanner, (value) => {
    const scanner = document.getElementById('qr-scanner')
    if (scanner) {
        qrScanner = new QrScanner(scanner, (result) => {
            const id = result.data.split('/').pop()
            qrScanner.stop()
            axios.get('/scanner/scan', {
                params: {
                    scan: id,
                    selectedScanner: selectedScanner.value
                }
            }).then(response => {
                console.log(response.data.registration)
                registrationInfo.value = response.data.registration
                console.log(registrationInfo.value)
                registrationInfoModalVisible.value = true
            }).catch(error => {

                console.log(error)
                // message.error("Error: " + error.response.data.message, 2)
                qrScanner.start()

            })

        }, {
            highlightScanRegion: true,
            highlightCodeOutline: true,
            returnDetailedScanResult: true,
            maxScansPerSecond: 2,
        })

        qrScanner.setInversionMode('both')
        qrScanner.start()
    }
})

</script>

<template>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <div :style='{ "background-image": "url(" + assets.background + ")", "min-height": "100vh", "min-width": "100vw", "background-size": "cover" }'
        class="text-white text-center">

        <Head :title="venue" />
        <div class="container">
            <div v-if="selectedScanner === null">
                <h1>{{ venue }}</h1>
                <h4><a href="/scanner">Back to List</a></h4>
                <div>
                    <div v-for="value, key in list" class="border-bottom border-top p-3 my-2"
                        v-on:click="selectedScanner = key">
                        {{ key }}
                    </div>
                </div>
            </div>

            <div :class="{ 'd-none': selectedScanner === null }">
                <h1>{{ selectedScanner }} - {{ venue }}</h1>
                <h4 v-on:click="selectedScanner = null">Back to List</h4>

                <div class="container">
                    <video id="qr-scanner"></video>
                </div>
            </div>
        </div>


    </div>

    <Modal v-model:open="registrationInfoModalVisible" title="Registration Information"
        v-on:cancel="() => { qrScanner.start() }" v-on:ok="() => { qrScanner.start() }">

        <div class="mb-3">
            <div class="form-label">Status</div>
            <div :class="{ 'form-control': true, 'is-invalid': !registrationInfo.recorded }">{{
        registrationInfo.recorded ?
            'ID Scanned' : 'ID Already Scanned!' }}
            </div>
        </div>
        <div class="mb-3">
            <div class="form-label">Full Name: </div>
            <div class="form-control"> {{ registrationInfo.user.name }}</div>

        </div>
        <div class="mb-3">
            <div class="form-label">Nickname: </div>
            <div class="form-control"> {{ registrationInfo.user.nickname }}</div>
        </div>
        <div class="mb-3">

            <div class="form-label">School: </div>
            <div class="form-control"> {{ registrationInfo.user.college.name }}</div>
        </div>
        <div class="mb-3">

            <div class="form-label">Section: </div>
            <div class="form-control"> {{ registrationInfo.user.section ? registrationInfo.user.section.program.code +
        '- ' +
        registrationInfo.user.section.year.name + registrationInfo.user.section.section : 'N/A' }}</div>

        </div>
        <div class="mb-3">

            <div class="form-label">T-shirt size: </div>
            <div class="form-control"> {{ registrationInfo.user.t_shirt_size.name }}</div>
        </div>
        <div class="mb-3">
            <div class="form-label">Paid: </div>
            <div class="form-control"> {{ registrationInfo.is_paid ? "Yes" : "No" }}</div>
        </div>
    </Modal>

</template>