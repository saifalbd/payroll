<template>
    <div class="row">
        <div class="col-4">
            <div class="mb-3">
                <label class="form-label fw-bold">Entry Time</label>
                <input type="time" class="form-control" v-model="form.start" id="exampleFormControlInput1"
                    :class="{ 'is-invalid': !!form.errors.start }">
                <div class="invalid-feedback">{{ form.errors.start }}</div>
            </div>
        </div>
        <div class="col-4">
            <div class="mb-3">
                <label for="exampleFormControlInput1x" class="form-label fw-bold">Exit Time</label>
                <input type="time" class="form-control" v-model="form.end" id="exampleFormControlInput1x"
                    :class="{ 'is-invalid': !!form.errors.end }">
                <div class="invalid-feedback">{{ form.errors.end }}</div>
            </div>
        </div>
        <div class="col-4 pt-4">
            <button type="button" class="btn btn-primary mt-2" @click="save">
                <i class="bi bi-save2"></i>
                <span class="mx-2">Save</span>
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Setting } from '@/types/vite-env';
import { useForm } from '@inertiajs/vue3';
import { inject, onMounted } from 'vue';
const successAlert = inject<Function>('successAlert') as Function;

const form = useForm<Setting.Attendance>({
    start: '',
    end: ''
})

const getAttendence = async ()=>{
    try {
        const url = route("admin.setting.getAttendence");
        const {data} = await window.axios.get(url);
        if(data){
            const item = data as Setting.Attendance;
            form.start = item.start;
            form.end = item.end;
        }
    } catch (error) {
        console.error(error)
    }
}
const save = () => {

    try {
        const url = route("admin.setting.attendenceStore");
        form.post(url,{
            onSuccess:()=>successAlert('Successfully update Attendence')
        })
    } catch (error) {
        console.error(error);
    }
}
onMounted(()=>{
    getAttendence()
})

</script>

<style scoped></style>