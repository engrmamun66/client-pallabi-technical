<template>
    <form @submit.prevent="submitFrom">
        <div class="row">
            <div class="col-md-6 mb-2">
                <label for="batch" class="form-label">Batch *</label>
                <multiselect 
                    v-model="selectedBatch" 
                    :options="batches"
                    track-by="id" 
                    @select="getBatchStudent"
                    @remove="getBatchStudent()"
                    placeholder="Select Batch"
                    label="batch_name"
                >
                </multiselect>
                <span id="error_name" class="has-error">{{ errors?.batch_id ? errors?.batch_id[0] : '' }}</span>
            </div>

            <div class="col-md-6 mb-2">
                <label for="course" class="form-label">Student *</label>
                <multiselect 
                    v-model="selectedStudent" 
                    :options="students"
                    track-by="id" 
                    placeholder="Select Student"
                    label="name"
                >
                </multiselect>
                <span id="error_name" class="has-error">{{ errors?.student_id ? errors?.student_id[0] : '' }}</span>
            </div>

            <div class="col-md-6 mb-3">
                <label for="course" class="form-label">Type *</label>
                <select v-model="form.type" class="form-control" id="type">
                    <option value="regular">Regular</option>
                    <option value="test">Test</option>
                </select>
                <span id="error_name" class="has-error">{{ errors?.type ? errors?.type[0] : '' }}</span>
            </div>

            <div class="col-md-6 mb-3">
                <label for="course" class="form-label">Certificate Number *</label>
                <input type="text" placeholder="Enter certificate number" v-model="form.certificate_number" class="form-control">
                <span id="error_name" class="has-error">{{ errors?.certificate_number ? errors?.certificate_number[0] : '' }}</span>
            </div>

            <div class="col-md-6 mb-3">
                <label for="course" class="form-label">Contact Hour *</label>
                <input type="text" placeholder="Enter contact hour" v-model="form.contact_hour" class="form-control">
                <span id="error_name" class="has-error">{{ errors?.contact_hour ? errors?.contact_hour[0] : '' }}</span>
            </div>

            <div class="col-md-6 mb-3">
                <label for="course" class="form-label">{{ form.type == 'regular' ? 'Position' : 'Mark Obtained *' }}</label>
                <input type="text" :placeholder="form.type == 'regular' ? 'Enter position' : 'Enter mark obtained'" v-model="form.mark_obtained" class="form-control">
                <span id="error_name" class="has-error">{{ errors?.mark_obtained ? errors?.mark_obtained[0] : '' }}</span>
            </div>

            <div class="col-md-6 mb-3">
                <label for="course" class="form-label">Issue Date *</label>
                <input type="date" v-model="form.issue_date" class="form-control">
                <span id="error_name" class="has-error">{{ errors?.issue_date ? errors?.issue_date[0] : '' }}</span>
            </div>

            <div v-if="form.type =='test'" class="col-md-6 mb-3">
                <label for="course" class="form-label">Test Date *</label>
                <input type="date" v-model="form.test_date" class="form-control">
                <span id="error_name" class="has-error">{{ errors?.test_date ? errors?.test_date[0] : '' }}</span>
            </div>

            <div v-if="form.type =='test'" class="col-md-6 mb-3">
                <label for="course" class="form-label">Grade *</label>
                <input type="text" placeholder="Enter grade" v-model="form.grade" class="form-control">
                <span id="error_name" class="has-error">{{ errors?.grade ? errors?.grade[0] : '' }}</span>
            </div>

            <div v-if="form.type =='test'" class="col-md-6 mb-3">
                <label for="course" class="form-label">Recommendation *</label>
                <input type="text" placeholder="Enter recommendation" v-model="form.recommendation" class="form-control">
                <span id="error_name" class="has-error">{{ errors?.recommendation ? errors?.recommendation[0] : '' }}</span>
            </div>

            <div class="col-md-12 d-flex justify-content-end">
                <button class="btn btn-success">{{ certificate ? 'Update' : 'Save' }}</button>
            </div>
        </div>
    </form>
</template>

<script setup>
import Multiselect from 'vue-multiselect'
import Swal from 'sweetalert2'
import axios from "axios";
import { onMounted, ref, watch } from "vue";

const props = defineProps({
    batches: {
        type: Array,
    },
    certificate: {
        type: Object,
        default: null,
    },
});
const selectedStudent = ref(null)
const selectedBatch = ref(null)
const students = ref([]);
const errors = ref(null)
const form = ref({
    batch_id: '',
    course_id: '',
    student_id: '',
    type: 'regular',
    certificate_number: '',
    contact_hour: '',
    test_date: '',
    issue_date: '',
    mark_obtained: '',
    grade: '',
    recommendation: '',
});

const getBatchStudent = async (data) => {
    if(data) {
        try {
            const response = await axios.get("/admin/get-batch-students", {
                params: {
                    batch_id: data.id
                }
            });
            students.value = response.data.students;
            
        } catch (error) {
            console.error("Error fetching users:", error);
        }
    }else{
        students.value = []
    }
};


const submitFrom = () => {
    form.value.student_id = selectedStudent.value?.id
    form.value.batch_id = selectedBatch.value?.id
    form.value.course_id = selectedBatch.value?.course_id
    console.log(form.value);
    
    if(props.certificate) {
        updateCertificate()
    }else{
        newCertificate()
    }
}

const newCertificate = () => {
    axios.post("/admin/certificates", form.value).then((response) => {
        console.log(response);
        getBatchStudent(selectedBatch.value)
        Swal.fire({
            toast: true,
            position: "top-end",
            timerProgressBar: true,
            icon: "success",
            title: "Certificate created successfully",
            showConfirmButton: false,
            timer: 1500
        })
         window.location.href = '/admin/certificates'
       
    }).catch((error) => {
        errors.value = error.response.data.errors
        console.log(error.response);
    })
}

const updateCertificate = () => {
    axios.put(`/admin/certificates/${props.certificate.id}`, form.value).then((response) => {
        console.log(response);
        getBatchStudent(selectedBatch.value)
        Swal.fire({
            toast: true,
            position: "top-end",
            timerProgressBar: true,
            icon: "success",
            title: "Certificate updated successfully",
            showConfirmButton: false,
            timer: 1500
        })
        window.location.href = '/admin/certificates'
       
    }).catch((error) => {
        errors.value = error.response.data.errors
        console.log(error.response);
    })
}

function getOldValues() {
    if(props.certificate) {
        form.value.type = props.certificate.type
        form.value.certificate_number = props.certificate.certificate_number
        form.value.contact_hour = props.certificate.contact_hour
        form.value.test_date = props.certificate.test_date
        form.value.mark_obtained = props.certificate.mark_obtained
        form.value.grade = props.certificate.grade
        form.value.recommendation = props.certificate.recommendation
        selectedBatch.value = props.certificate.batch
        selectedStudent.value = props.certificate.student
    }
}

onMounted(async () => {
    getOldValues();
});
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style lang="scss" scoped></style>
