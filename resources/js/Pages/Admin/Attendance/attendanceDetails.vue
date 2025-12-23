<template>
    <div>
        <main class="container-fluid">
            <div class="d-flex justify-content-end align-items-center mt-2 mb-3">
                <input type="date" class="form-control form-control-sm w-auto" v-model="selectedDate" @change="fetchDailyAttendance">
            </div>
            <div class="edge-report mt-3" v-if="employees.length">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th class="text-right">Id</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Time In / Out</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(emp, index) in employees" :key="emp.id ?? index">
                            <td>{{ emp.employee_name }}</td>
                            <td class="text-right">{{ emp.employee_id }}</td>
                            <td class="text-right">
                                <button v-if="emp.attendance?.attendance_type" @click.prevent="updateModal(emp.attendance, emp.employee_name, emp.id)" :class="getAttClass(emp.attendance.attendance_type.id)" class="btn btn-sm">{{emp.attendance.attendance_type.short_type}}</button>
                                <button v-else @click.prevent="openAttendanceModal(emp)" class="btn btn-sm btn-outline-secondary dropdown-toggle"></button>
                            </td>
                            <!-- Time In / Out -->
                            <td class="text-center">
                                <template v-if="emp.attendance">
                                    <div v-if="emp.attendance.in_outs?.length">
                                        <div
                                            v-for="(io, ioIndex) in emp.attendance.in_outs"
                                            :key="ioIndex"
                                        >
                                            {{ io.time_in? to12Hour(io.time_in) : '-' }} to {{ io.time_out? to12Hour(io.time_out) : '-' }}
                                        </div>
                                    </div>
                                    <div v-else>-</div>
                                </template>
                                <div v-else>-</div>
                            </td>

                            <!-- Status -->
                            <td class="text-center">
                                <template v-if="emp.attendance">
                                    <span
                                        v-if="emp.attendance.attendance_type"
                                        :class="getAttClass(emp.attendance.attendance_type.id)"
                                    >
                                        {{ emp.attendance.attendance_type.type_name }}
                                    </span>

                                    <span v-else class="text-secondary fw-bold">
                                        Not Set
                                    </span>
                                </template>
                                <div v-else>-</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="text-center mt-4 text-secondary">
                No attendance records found for selected date.
            </div>
        </main>
        <!-- Modal -->
        <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content relative">
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <!-- <h6>{{attendanceForm.day}}-{{currentMonthName}}</h6> -->
                            <h6>Employee Name: <span class="font-weight-bold">{{attendanceForm.emp_name}}</span></h6>
                        </div>
                        <div>
                            <v-select :class="{ 'is-invalid': errors.type }" placeholder="Select Type" autocomplete="off" 
                                :reduce="(el: { id: number; })=>el.id" label="type_name" v-model="attendanceForm.type" 
                                :options="attendanceTypes" :selectOnTab="true">
                            </v-select>
                            <div class="invalid-feedback" v-if="errors.type">{{ errors.type[0] }}</div>
                        </div>
                        <div class="row" v-if="attendanceForm.type == 1">
                            <div class="col-md-6 mt-3">
                                <label class="mb-0" for="time_in">Select time in:</label>
                                <input type="time" v-model="attendanceForm.time_in" class="form-control form-control-sm" :class="{ 'is-invalid': errors.time_in }" name="time_in" min="9:00" max="21:00">
                                <div class="invalid-feedback" v-if="errors.time_in">{{ errors.time_in[0] }}</div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="mb-0" for="time_in">Select time out:</label>
                                <input type="time" v-model="attendanceForm.time_out" class="form-control form-control-sm" name="time_in" min="9:00" max="21:00">
                            </div>
                        </div>
                        <button @click.prevent="saveAttendance" class="btn btn-sm btn-success w-100 mt-4">Save</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x"></i>
                            <span class="mx-2">Close</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal-lg fade" id="attendanceUpdate" tabindex="-1" aria-labelledby="attendanceUpdateModalLabel"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content relative">
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <!-- <h6>{{attUpdateForm.day}}-{{currentMonthName}}</h6> -->
                            <h6>Employee Name: <span class="font-weight-bold">{{attUpdateForm.emp_name}}</span></h6>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <v-select class="v-select-sm" placeholder="Select Type" autocomplete="off" 
                                    :reduce="(el:{id:number})=>el.id" label="type_name" v-model="attUpdateForm.type" 
                                    :options="attendanceTypes" :selectOnTab="true">
                                </v-select>
                            </div>
                            <div v-if="attUpdateForm.type != 1" class="col-md-2">
                                <button @click.prevent="updateAttendanceType" class="btn btn-sm btn-success">Update</button>
                            </div>
                        </div>
                        <div v-if="attUpdateForm.type == 1">
                            <div v-for="(in_out,in_out_index) in attUpdateForm.in_outs" :key="'inout'+in_out_index" class="row">
                                <div class="col-md-5 mt-3">
                                    <label class="mb-0" for="time_in">Select time in:</label>
                                    <input type="time" v-model="in_out.time_in" class="form-control form-control-sm" name="time_in" min="9:00" max="21:00">
                                </div>
                                <div class="col-md-5 mt-3">
                                    <label class="mb-0" for="time_in">Select time out:</label>
                                    <input type="time" v-model="in_out.time_out" class="form-control form-control-sm" name="time_in" min="9:00" max="21:00">
                                </div>
                                <div class="col-md-2 mt-3 d-flex flex-column-reverse">
                                    <button @click="updateInOut(in_out)" class="btn btn-sm btn-success">Update</button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <h6 role="button" class="text-primary font-weight-bold" @click.prevent="addTimeInOut">Add Another Entry</h6>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x"></i>
                            <span class="mx-2">Close</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, inject } from 'vue';
import vSelect from 'vue-select';
import axios from 'axios';

const bootstrap = inject<any>('bootstrap');

interface AttendanceType {
    id: number;
    type_name: string;
    short_type: string;
}

interface InOut {
    time_in: string | null;
    time_out: string | null;
}

interface Attendance {
    id: number;
    date: string;
    day: number | null;
    in_outs: InOut[];
    attendance_type: AttendanceType;
}

interface EmployeeAttendance {
    id: number;
    employee_name: string;
    employee_id: number;
    avatarUrl?: string;
    attendance: Attendance | null; // ✅ single object
}

interface attendanceStoreForm {
    employee_id: number | null;
    emp_name: string;
    day: number | null;
    date: string | null;
    type: number | null;
    time_in: string;
    time_out: string;
}

const attendanceForm = ref<attendanceStoreForm>({
    employee_id:null,
    emp_name:'',
    day:0,
    date:null,
    type:null,
    time_in:'',
    time_out:'',
});

interface attendanceUpdateForm {
    id: number | null;
    employee_id: number | null;
    emp_name: string;
    day: number | null;
    date: string | null;
    type: number | null;
    in_outs: {
        id?: number;
        time_in: string;
        time_out: string;
    }[];
}

const attUpdateForm = ref<attendanceUpdateForm>({
    id:null,
    employee_id:null,
    emp_name:'',
    day:0,
    date:null,
    type:null,
    in_outs:[],
});

const errors = ref<Record<string, string[]>>({});
const employees = ref<EmployeeAttendance[]>([]);
const attendanceTypes = ref<AttendanceType[]>([]);
const d = new Date();
const selectedDate = ref(
    `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`
);

const openAttendanceModal = (emp: any)=>{
    errors.value = {};
    attendanceForm.value.employee_id = emp.id;
    attendanceForm.value.date = selectedDate.value;

    attendanceForm.value.emp_name = emp.employee_name;
    // attendanceForm.value.day = day;
    const bs = new bootstrap.Modal('#attendanceModal', {
        keyboard: false
    });
    bs.show(document.body)
};

const saveAttendance = async()=>{
    try{
        const url = `/admin/attendances`;
        const { data } = await window.axios.post(url, attendanceForm.value);
        fetchDailyAttendance();
        const bs = bootstrap.Modal.getOrCreateInstance('#attendanceModal');
        bs.hide();
    }
    
    catch (error: any) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors;
        }
    }
};

const updateModal = (att: any, emp_name: string, emp_id: number) => {
    attUpdateForm.value.emp_name = emp_name;
    attUpdateForm.value.day = att.day;
    attUpdateForm.value.type = att.attendance_type.id;
    attUpdateForm.value.employee_id = emp_id;
    attUpdateForm.value.id = att.id;
    attUpdateForm.value.date = att.date;

    if (att.in_outs?.length) {
        attUpdateForm.value.in_outs = att.in_outs.map(
            (item: any) => ({
                id: item.id,
                time_in: item.time_in,
                time_out: item.time_out,
            })
        );
    } else {
        attUpdateForm.value.in_outs = [{ time_in: '', time_out: '' }];
    }

    const modalEl = document.getElementById('attendanceUpdate');
    const bs = new bootstrap.Modal(modalEl);
    bs.show();
};

const addTimeInOut = () => {
    attUpdateForm.value.in_outs.push({
        time_in: '',
        time_out: '',
    });
};

const updateInOut = async (in_out: any) => {
    try {
        await window.axios.post(
            `/admin/update-in-out/${attUpdateForm.value.id}`,
            in_out
        );

        fetchDailyAttendance();

        const modalEl = document.getElementById('attendanceUpdate');
        const bs = bootstrap.Modal.getInstance(modalEl);
        bs?.hide();
    } 
    catch (error) {}
};

const updateAttendanceType = async () => {
    try {
        await window.axios.post(
            `/admin/update-attendance-type/${attUpdateForm.value.id}`,
            {
                type: attUpdateForm.value.type,
            }
        );
        
        fetchDailyAttendance();

        const modalEl = document.getElementById('attendanceUpdate');
        const bs = bootstrap.Modal.getInstance(modalEl);
        bs?.hide();
    } catch (error) {}
};

const fetchDailyAttendance = async () => {
    employees.value = [];
    try {
        const { data } = await axios.get(`/admin/daily-attendance`, {
            params: { date: selectedDate.value }
        });
        employees.value = data;
    } catch (error) {
        console.error(error);
        employees.value = [];
    }
};

const fetchAttendanceTypes = async () => {
    try {
        const { data } = await axios.get(`/admin/all-attendance-type`);
        attendanceTypes.value = data;
    } catch (error) {
        console.error(error);
    }
};

const to12Hour = (time24: string): string =>{
    const [hour, minute] = time24.split(':');
    const h = parseInt(hour, 10);
    const period = h >= 12 ? 'PM' : 'AM';
    const hour12 = h % 12 || 12;

    return `${hour12}:${minute} ${period}`;
}

const getAttClass = (type_id: number)=>{
    if(type_id == 1)return 'btn-success';
    if(type_id == 2)return 'btn-danger';
    if(type_id == 3)return 'btn-warning';
};

onMounted(async () => {
    await fetchAttendanceTypes();
    await fetchDailyAttendance();
});
</script>

<style scoped>
/* Optional styling */
</style>
