<template>
    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Students List</h2>
            <Button label="Create Student" icon="pi pi-plus" @click="showCreateDialog = true" />
        </div>
        
        <DataTable v-model:filters="filters" :value="students" paginator showGridlines :rows="10" dataKey="student_id"
            filterDisplay="menu" :loading="loading" :globalFilterFields="['name', 'subject', 'marks']">
            <template #header>
                <div class="flex justify-between">
                    <Button type="button" icon="pi pi-filter-slash" label="Clear" outlined @click="clearFilter()" />
                    <IconField>
                        <InputIcon>
                            <i class="pi pi-search" />
                        </InputIcon>
                        <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                    </IconField>
                </div>
            </template>
            <template #empty> No students found. </template>
            <template #loading> Loading student data. Please wait. </template>
            <Column field="name" header="Name" style="min-width: 12rem">
                <template #body="{ data }">
                    <div class="flex items-center">
                    <img
                    src="/storage/app/public/student/default.png"
                        alt="Student Image"
                        class="w-12 h-12 rounded-full"
                    />
                    {{ data.name }}
                    </div>
                </template>
                <template #filter="{ filterModel }">
                    <InputText v-model="filterModel.value" type="text" placeholder="Search by name" />
                </template>
            </Column>
            <Column field="subject" header="Subject" style="min-width: 12rem">
                <template #body="{ data }">
                    {{ data.subject }}
                </template>
                <template #filter="{ filterModel }">
                    <InputText v-model="filterModel.value" type="text" placeholder="Search by subject" />
                </template>
            </Column>
            <Column field="marks" header="Marks" style="min-width: 10rem">
                <template #body="{ data }">
                    {{ data.marks }}
                </template>
                <template #filter="{ filterModel }">
                    <InputNumber v-model="filterModel.value" mode="decimal" />
                </template>
            </Column>
            <Column header="Actions" style="min-width: 10rem">
                <template #body="{ data }">
                    <Button icon="pi pi-pencil" @click.prevent="editStudent(data)" class="mr-2" />
                    <Button icon="pi pi-trash" @click.prevent="deleteStudent(data.student_id)" severity="danger" />
                </template>
            </Column>
        </DataTable>

        
        <Dialog header="Create Student" v-model:visible="showCreateDialog" :modal="true" :responsive="true" :closable="true">
            <form @submit.prevent="saveStudent">
                <div class="flex flex-column gap-3">
                    <InputText v-model="newStudent.name" placeholder="Name" label="Name" />
                    <InputText v-model="newStudent.subject" placeholder="Subject" label="Subject" />
                    <InputNumber v-model="newStudent.marks" placeholder="Marks" label="Marks" mode="decimal" />
                    <div class="flex justify-end">
                        <Button type="submit" label="Save" icon="pi pi-check" />
                        <Button label="Cancel" icon="pi pi-times" class="ml-2" @click="showCreateDialog = false" />
                    </div>
                </div>
            </form>
        </Dialog>

    
        <Dialog header="Edit Student" v-model:visible="showEditDialog" :modal="true" :responsive="true" :closable="true">
            <form @submit.prevent="updateStudent">
                <div class="flex flex-column gap-3">
                    <InputText v-model="editStudentData.name" placeholder="Name" label="Name" />
                    <InputText v-model="editStudentData.subject" placeholder="Subject" label="Subject" />
                    <InputNumber v-model="editStudentData.marks" placeholder="Marks" label="Marks" mode="decimal" />
                    <div class="flex justify-end">
                        <Button type="submit" label="Update" icon="pi pi-check" />
                        <Button label="Cancel" icon="pi pi-times" class="ml-2" @click="showEditDialog = false" />
                    </div>
                </div>
            </form>
        </Dialog>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from '@primevue/core/api';
import axios from 'axios'; 
import { useForm } from '@inertiajs/vue3';

const students = ref([]);
const filters = ref();
const loading = ref(true);
const showCreateDialog = ref(false);
const showEditDialog = ref(false);
const newStudent = useForm({ name: '', subject: '', marks: null });
const editStudentData = ref({ name: '', subject: '', marks: null, student_id: null });


onMounted(async () => {
    loading.value = true;
    try {
        let response = await axios.get('/getstudents');
        students.value = response.data; 
    } catch (error) {
        console.error("Error fetching students:", error);
    } finally {
        loading.value = false; 
    }
});

// Initialize filters
const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        name: { value: null, matchMode: FilterMatchMode.CONTAINS },
        subject: { value: null, matchMode: FilterMatchMode.CONTAINS },
        marks: { value: null, matchMode: FilterMatchMode.EQUALS }
    };
};

initFilters();

const clearFilter = () => {
    initFilters();
};

const saveStudent = async() => {
    try {
        await newStudent.post('/savestudent');
        showCreateDialog.value = false; 
         setInterval(async() => {
            let response = await axios.get('/getstudents');
            students.value = response.data; 
        }, 2000)

    } catch (error) {
        console.error("Error creating student:", error);
        alert("Error creating student.");
    } finally {
        newStudent.reset(); 
    }
};

const editStudent = (student) => {
    editStudentData.value = { ...student }; 
    showEditDialog.value = true;
};

const updateStudent = async () => {
    try {
        await axios.put(`/updatestudent/${editStudentData.value.student_id}`, editStudentData.value);
        showEditDialog.value = false;
        let response = await axios.get('/getstudents');
        students.value = response.data; 
    } catch (error) {
        console.error("Error updating student:", error);
        alert("Error updating student.");
    }
};

const deleteStudent = async (studentId) => {
    if (confirm("Are you sure you want to delete this student?")) {
        try {
            await axios.delete(`/deleteStudent/${studentId}`);
            students.value = students.value.filter(student => student.student_id !== studentId);
            alert("Student deleted successfully.");
        } catch (error) {
            console.error("Failed to delete student:", error);
            alert("Error deleting student.");
        }
    }
};
</script>

<style scoped>
</style>
