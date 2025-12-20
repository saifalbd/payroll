<template>
    <Layout :auth="auth">
        <div class="container-fluid d-flex justify-content-between align-items-center my-4">
            <h5 class="fw-bold ms-1" style="color: #e3342f">Attendance</h5>
        </div>
        <main class="container-fluid">
            <div class="edge-report mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th class="text-right">Id</th>
                            <th class="text-center" v-for="(day, day_index) in daysArray" :key="'th'+day_index">{{day.day}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(emp, index) in employees" :key="'emp'+index">
                            <td>{{emp.employee_name}}</td> 
                            <td class="text-right">{{emp.employee_id}}</td>
                            <td class="text-center" v-for="(att, att_index) in emp.attendances" :key="'th'+att_index">
                                <button v-if="att.attendance_type" @click.prevent="updateModal(att, emp.employee_name, emp.id)" :class="getAttClass(att.attendance_type.id)" class="btn btn-sm">{{att.attendance_type.short_type}}</button>
                                <button v-else @click.prevent="openAttendanceModal(emp,att.day)" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
        <!-- Modal -->
        <div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel"
            data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content relative">
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <h6>{{attendanceForm.day}}-{{currentMonthName}}</h6>
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
                                <input type="time" v-model="attendanceForm.time_in" class="form-control form-control-sm" :class="{ 'is-invalid': errors.time_in }" id="time_in" name="time_in" min="9:00" max="21:00">
                                <div class="invalid-feedback" v-if="errors.time_in">{{ errors.time_in[0] }}</div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="mb-0" for="time_in">Select time out:</label>
                                <input type="time" v-model="attendanceForm.time_out" class="form-control form-control-sm" id="time_in" name="time_in" min="9:00" max="21:00">
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
                            <h6>{{attUpdateForm.day}}-{{currentMonthName}}</h6>
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
                                    <input type="time" v-model="in_out.time_in" class="form-control form-control-sm" id="time_in" name="time_in" min="9:00" max="21:00">
                                </div>
                                <div class="col-md-5 mt-3">
                                    <label class="mb-0" for="time_in">Select time out:</label>
                                    <input type="time" v-model="in_out.time_out" class="form-control form-control-sm" id="time_in" name="time_in" min="9:00" max="21:00">
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
    </Layout>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { onMounted, ref, inject } from 'vue';
import Layout from '../../../components/Layout.vue';
import vSelect from 'vue-select';
const { auth } = defineProps<{ auth: Auth }>();

const bootstrap = inject<any>('bootstrap');

const options = {
    paging: false
}

interface employeeAttendance {
    id: number;
    employee_name: string;
    employee_id: number;
    attendances: {
        day: number;
        attendance_type: {
            id: number;
            short_type: string;
        } | null;
        in_outs: {
            id?: number;
            time_in: string;
            time_out: string;
        }[];
    }[];
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
const employees = ref<employeeAttendance[]>([]);
const attendanceTypes = ref<any[]>([]);
const from_date = ref('');
const to_date = ref('');

const daysArray = ref<{day:number}[]>([]);
const currentYear = ref(0);
const currentMonth = ref(0);
const currentMonthName = ref('');
const monthNames = ref(["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
]);

const openAttendanceModal = (emp: any, day: number)=>{
    errors.value = {};
    attendanceForm.value.employee_id = emp.id;
    attendanceForm.value.date = `${currentYear.value}-${String(currentMonth.value+1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;

    attendanceForm.value.emp_name = emp.employee_name;
    attendanceForm.value.day = day;
    const bs = new bootstrap.Modal('#attendanceModal', {
        keyboard: false
    });
    bs.show(document.body)
};

const saveAttendance = async()=>{
    try{
        const url = `/admin/attendances`;
        const { data } = await window.axios.post(url, attendanceForm.value);
        const index = employees.value.findIndex(e=>e.id == attendanceForm.value.employee_id);
        if(index !== -1){
            const attIndex = employees.value[index].attendances.findIndex(a=>a.day == attendanceForm.value.day);
            if(attIndex !== -1){
                const attType = attendanceTypes.value.find((at: any)=>at.id == attendanceForm.value.type);
                employees.value[index].attendances[attIndex].attendance_type = attType;
            }
        }
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

        employees.value = employees.value.map((emp) => {
            if (emp.id === attUpdateForm.value.employee_id) {
                emp.attendances = emp.attendances.map((att) => {
                    if (att.day === attUpdateForm.value.day) {
                        att.in_outs = attUpdateForm.value.in_outs;
                        att.attendance_type = {
                            id: 1,
                            short_type: 'P',
                        };
                    }
                    return att;
                });
            }
            return emp;
        });

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
        const attType = attendanceTypes.value.find(
            (at: any) => at.id == attUpdateForm.value.type
        );
        employees.value = employees.value.map((emp) => {
            if (emp.id === attUpdateForm.value.employee_id) {
                emp.attendances = emp.attendances.map((att) => {
                    if (att.day === attUpdateForm.value.day) {
                        att.attendance_type = attType;
                        if (attType.id != 1) {
                            att.in_outs = [];
                        }
                    }
                    return att;
                });
            }
            return emp;
        });
        const modalEl = document.getElementById('attendanceUpdate');
        const bs = bootstrap.Modal.getInstance(modalEl);
        bs?.hide();
    } catch (error) {}
};

const getAttClass = (type_id: number)=>{
    if(type_id == 1)return 'btn-success';
    if(type_id == 2)return 'btn-danger';
    if(type_id == 3)return 'btn-warning';
};

const fetchAttendances = async ()=>{
    try{
        const url = `/admin/all-attendances?from_date=${from_date.value}&to_date=${to_date.value}`;
        const { data } = await window.axios.get(url);

        employees.value = data.map((emp: any) => {
            const filledDays = daysArray.value.map(d => ({
                day: d.day,
                attendance_type: null
            }));

            if (emp.attendances?.length) {
                emp.attendances.forEach((att: any) => {
                    const index = Number(att.day) - 1;
                    if (filledDays[index]) {
                        filledDays[index] = att;
                    }
                });
            }

            return {
                ...emp,
                attendances: filledDays
            };
        });
        
    }catch(error){
        
    }
};

const fetchAttendanceTypes = async ()=>{
    try{
        const url = `/admin/all-attendance-type`;
        const { data } = await window.axios.get(url);
        attendanceTypes.value = data;
    }catch(error){
        
    }
};

const makeDaysArray = ()=>{
    let today = new Date();
    let curYear = today.getFullYear();
    currentYear.value = today.getFullYear();
    let curMonth = today.getMonth();
    currentMonth.value = today.getMonth();
    currentMonthName.value = monthNames.value[curMonth];
    if(curMonth == 11){
        curYear ++;
        curMonth = 0;
    }
    let max_day = (new Date(curYear, curMonth+1, 0)).getDate();
    from_date.value = `${currentYear.value}-${String(currentMonth.value+1).padStart(2, '0')}-${String(1).padStart(2, '0')}`;
    to_date.value = `${currentYear.value}-${String(currentMonth.value+1).padStart(2,'0')}-${String(max_day).padStart(2,'0')}`;
    daysArray.value = Array.from({length: max_day}, (_, i) => {
        return {day:(i + 1)}
    });
}

onMounted(async ()=>{
    makeDaysArray();
    await fetchAttendances();
    await fetchAttendanceTypes();
});

</script>

<style scoped>
</style>