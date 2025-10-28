<template>
    <form>
        <div class="row">
            <!-- New: Certificate Format Dropdown -->
            <div class="col-md-6 mb-3">
                <label for="certificate_format" class="form-label">Certificate Format *</label>
                <select v-model="form.certificate_format" class="form-control" id="certificate_format">
                    <option value="old">Old Format (With Image/PDF)</option>
                    <option value="new">New Format (Without Image/PDF)</option>
                </select>
                <span class="has-error">{{ errors?.certificate_format ? errors?.certificate_format[0] : '' }}</span>
            </div>

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
                <span class="has-error">{{ errors?.batch_id ? errors?.batch_id[0] : '' }}</span>
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
                <span class="has-error">{{ errors?.student_id ? errors?.student_id[0] : '' }}</span>
            </div>

            <div class="col-md-6 mb-3">
                <label for="course" class="form-label">Type *</label>
                <select v-model="form.type" class="form-control" id="type">
                    <option value="regular">Regular</option>
                    <option value="test">Test</option>
                </select>
                <span class="has-error">{{ errors?.type ? errors?.type[0] : '' }}</span>
            </div>

            <div class="col-md-6 mb-3">
                <label for="course" class="form-label">Certificate Number *</label>
                <input type="text" placeholder="Enter certificate number" v-model="form.certificate_number" class="form-control">
                <span class="has-error">{{ errors?.certificate_number ? errors?.certificate_number[0] : '' }}</span>
            </div>

            <div class="col-md-6 mb-3">
                <label for="course" class="form-label">Contact Hour *</label>
                <input type="text" placeholder="Enter contact hour" v-model="form.contact_hour" class="form-control">
                <span class="has-error">{{ errors?.contact_hour ? errors?.contact_hour[0] : '' }}</span>
            </div>

            <div class="col-md-6 mb-3">
                <label for="course" class="form-label">{{ form.type == 'regular' ? 'Position' : 'Mark Obtained *' }}</label>
                <input type="text" :placeholder="form.type == 'regular' ? 'Enter position' : 'Enter mark obtained'" v-model="form.mark_obtained" class="form-control">
                <span class="has-error">{{ errors?.mark_obtained ? errors?.mark_obtained[0] : '' }}</span>
            </div>

            <div class="col-md-6 mb-3">
                <label for="course" class="form-label">Issue Date *</label>
                <input type="date" v-model="form.issue_date" class="form-control">
                <span class="has-error">{{ errors?.issue_date ? errors?.issue_date[0] : '' }}</span>
            </div>

            <!-- File Upload Fields - Only show for Old Format -->
            <div v-if="form.certificate_format === 'old'" class="col-md-6">
                <label for="image" class="form-label">Image (File must be jpg, jpeg, png)</label>
                <input 
                    type="file" 
                    @change="handleImageUpload" 
                    class="form-control" 
                    accept="image/jpeg,image/jpg,image/png"
                    ref="imageInput"
                >
                <span class="has-error">{{ errors?.image ? errors?.image[0] : '' }}</span>
            </div>

            <div v-if="form.certificate_format === 'old'" class="col-md-6">
                <label for="pdf">PDF (File must be pdf)</label>
                <input 
                    id="pdf" 
                    type="file" 
                    @change="handlePdfUpload" 
                    class="form-control" 
                    accept=".pdf"
                    ref="pdfInput"
                >
                <span class="has-error">{{ errors?.pdf ? errors?.pdf[0] : '' }}</span>
            </div>

            <!-- Test Type Fields -->
            <div v-if="form.type =='test'" class="col-md-6 mb-3">
                <label for="course" class="form-label">Test Date *</label>
                <input type="date" v-model="form.test_date" class="form-control">
                <span class="has-error">{{ errors?.test_date ? errors?.test_date[0] : '' }}</span>
            </div>

            <div v-if="form.type =='test'" class="col-md-6 mb-3">
                <label for="course" class="form-label">Grade *</label>
                <input type="text" placeholder="Enter grade" v-model="form.grade" class="form-control">
                <span class="has-error">{{ errors?.grade ? errors?.grade[0] : '' }}</span>
            </div>

            <div v-if="form.type =='test'" class="col-md-6 mb-3">
                <label for="course" class="form-label">Recommendation *</label>
                <input type="text" placeholder="Enter recommendation" v-model="form.recommendation" class="form-control">
                <span class="has-error">{{ errors?.recommendation ? errors?.recommendation[0] : '' }}</span>
            </div>

            <div class="col-md-12 d-flex justify-content-end">
                <button class="btn btn-success" @click.prevent="submitFrom">{{ certificate ? 'Update' : 'Save' }}</button>
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

console.log('🎯 CertificateComponent created!');
console.log('Batches data:', props.batches);

const selectedStudent = ref(null)
const selectedBatch = ref(null)
const students = ref([]);
const errors = ref(null)
const imageInput = ref(null);
const pdfInput = ref(null);

const form = ref({
    certificate_format: 'old', // Default to old format
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
    image: null,
    pdf: null,
});

// File upload handlers
const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.value.image = file;
    }
};

const handlePdfUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.value.pdf = file;
    }
};

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
    } else {
        students.value = []
    }
};

const submitFrom = async () => {
    try {
        form.value.student_id = selectedStudent.value?.id
        form.value.batch_id = selectedBatch.value?.id
        form.value.course_id = selectedBatch.value?.course_id
        
        console.log("Submitting form with format:", form.value.certificate_format);
        
        // Create FormData
        const formData = new FormData();
        
        // Append all form fields
        Object.keys(form.value).forEach(key => {
            if (form.value[key] !== null && form.value[key] !== undefined) {
                // For new format, don't send image/pdf files
                if (form.value.certificate_format === 'new' && (key === 'image' || key === 'pdf')) {
                    return; // Skip file fields for new format
                }
                
                if (key === 'image' || key === 'pdf') {
                    // Append files directly
                    if (form.value[key] instanceof File) {
                        formData.append(key, form.value[key]);
                    }
                } else {
                    formData.append(key, form.value[key]);
                }
            }
        });

        // Debug: Check what's in formData
        console.log('FormData contents:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ', pair[1]);
        }

        const url = props.certificate 
            ? `/admin/certificates/${props.certificate.id}`
            : '/admin/certificates';

        const method =  'post';

        // Add _method for PUT requests if needed
        if (props.certificate) {
            formData.append('_method', 'PUT');
        }
        const response = await axios({
            method: method,
            url: url,
            data: formData,
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        Swal.fire({
            toast: true,
            position: "top-end",
            timerProgressBar: true,
            icon: "success",
            title: `Certificate ${props.certificate ? 'updated' : 'created'} successfully`,
            showConfirmButton: false,
            timer: 1500
        });

        window.location.href = '/admin/certificates';

    } catch (error) {
        errors.value = error.response?.data?.errors || {};
        console.error('Error:', error.response);
    }
};

function getOldValues() {
    if(props.certificate) {
        form.value.certificate_format = props.certificate.certificate_format || 'old'
        form.value.type = props.certificate.type
        form.value.certificate_number = props.certificate.certificate_number
        form.value.contact_hour = props.certificate.contact_hour
        form.value.test_date = props.certificate.test_date
        form.value.issue_date = props.certificate.issue_date
        form.value.mark_obtained = props.certificate.mark_obtained
        form.value.grade = props.certificate.grade
        form.value.recommendation = props.certificate.recommendation
        selectedBatch.value = props.certificate.batch
        selectedStudent.value = props.certificate.student
    }
}

onMounted(() => {
    getOldValues();
});
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.has-error {
    color: #dc3545;
    font-size: 0.875em;
    margin-top: 0.25rem;
    display: block;
}
</style>