<template>
    <form @submit.prevent="submitFrom">
        <div class="row">
            <div class="col-md-6 mb-2">
                <label for="course" class="form-label">Course *</label>
                <multiselect 
                    v-model="selectedCourse" 
                    :options="courses"
                    track-by="id" 
                    placeholder="Select Course"
                    label="course_name"
                >
                </multiselect>
                <span id="error_name" class="has-error">{{ errors?.course_id ? errors?.course_id[0] : '' }}</span>
            </div>
            <input type="hidden" name="course_id" v-model="course_id">

            <div class="col-md-6 mb-2">
                <label for="course" class="form-label">Student *</label>
                <multiselect 
                    v-model="selectedStudent" 
                    :options="students"
                    track-by="id" 
                    @search-change="getAllStudent"
                    @select="addStudent"
                    label="name"
                >
                </multiselect>
                <span id="error_name" class="has-error">{{ errors?.students ? errors?.students[0] : '' }}</span>
            </div>

            <input type="hidden" name="selected_student_ids" v-model="selected_student_ids">

            <div class="col-md-12 mb-3">
                <label for="course" class="form-label">Batch Name *</label>
                <input type="text" name="batch_name" placeholder="enter batch name" class="form-control" v-model="form.batch_name">
                <span id="error_name" class="has-error">{{ errors?.batch_name ? errors?.batch_name[0] : '' }}</span>
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="table-active">
                                <th width="5">#</th>
                                <th width="400">Student Name</th>
                                
                                <th width="300">Father Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th width="10" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(student, i) in selectedStudents" :key="`student_${i}`">
                                <td>{{ i + 1 }}</td>
                                <td class="px-1">{{ student.name }}</td>
                                <td>{{ student?.fathers_name }}</td>                            
                                <td>{{ student?.address }}</td>                            
                                <td>{{ student?.mobile }}</td>                            
                                <td class="text-end">
                                    <button title="Remove student" @click="selectedStudents.splice(i, 1)" class="btn btn-outline-danger btn-square btn-xs" type="button">
                                        <i class="fa fa-minus-circle"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-12 d-flex justify-content-end">
                <button class="btn btn-success">{{ batch ? 'Update' : 'Create' }}</button>
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
    courses: {
        type: Array,
    },
    batch: {
        type: Object,
        default: null,
    }
});
const selectedStudent = ref(null)
const selectedCourse = ref(null)
const students = ref([]);
const selectedStudents = ref([])
const errors = ref(null)
const form = ref({
    batch_name: '',
    student_ids: [],
    course_id: null,
});
const course_id = ref(null)
const selected_student_ids = ref([])

watch(selectedCourse, (course) => {
    course_id.value = course.id
}, {deep: true});

watch(selectedStudents, (students) => {
    selected_student_ids.value = students.map(student => student.id)
}, {deep: true});

const getAllStudent = async (searchBy = "") => {
    try {
        const response = await axios.get("/admin/get-all-students", {
            params: {
                name: searchBy
            }
        });
        students.value = response.data.students;
        
    } catch (error) {
        console.error("Error fetching users:", error);
    }
};

const submitFrom = () => {
    form.value.student_ids = selectedStudents.value.map(student => student.id)
    form.value.course_id = selectedCourse.value?.id

    if(props.batch) {
        updateBatch()
    }else{
        newBatch()
    }
}

const newBatch = () => {
    axios.post("/admin/batch", form.value).then((response) => {
        console.log(response.data);
        
       if(response.data?.errors) {
        errors.value = response.data.errors
       }else{
        Swal.fire({
            toast: true,
            position: "top-end",
            timerProgressBar: true,
            icon: "success",
            title: "Batch created successfully",
            showConfirmButton: false,
            timer: 1500
        });
        window.location.href = '/admin/batch'
       }
    });
}

const updateBatch = () => {
    axios.put(`/admin/batch/${props.batch.id}`, form.value).then((response) => {
        console.log(response.data);
        
       if(response.data?.errors) {
        errors.value = response.data.errors
       }else{
        Swal.fire({
            toast: true,
            position: "top-end",
            timerProgressBar: true,
            icon: "success",
            title: "Batch updated successfully",
            showConfirmButton: false,
            timer: 1500
        });
        window.location.href = '/admin/batch'
       }
    });
}

function addStudent(data) {
    let exists = selectedStudents.value.find((student) => student.id === data.id);
    if(!exists) {
        selectedStudents.value.push(data)
    }
    else{
        Swal.fire({
            toast: true,
            position: "top-end",
            timerProgressBar: true,
            icon: "warning",
            title: "Already selected",
            showConfirmButton: false,
            timer: 1500
        });
    }
    selectedStudent.value = null
}

function getOldValues() {
    if(props.batch) {
        form.value.batch_name = props.batch.batch_name
        selectedStudents.value = props.batch.students
        selectedCourse.value = props.batch.course
    }
}

onMounted(async () => {
    await getAllStudent();
    getOldValues();
    console.log(props.batch);
});
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style lang="scss" scoped></style>
