<template>
    <div class="login-container">
        <div class="card login-card">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">
                    <i class="bi bi-person-circle me-2"></i> Employee Login
                </h3>

                <form>
                    <div class="mb-3">
                        <label for="employeeId" class="form-label">User Type</label>
                        
                        <select class="form-select form-select-lg"  v-model="form.type" :class="{ 'is-invalid': !!form.errors.type }">
                            <option :value="null">Select User Type</option>
                            <option value="employee">Employee</option>
                            <option value="admin">Admin</option>
                        
                        </select>

                        <div class="invalid-feedback">
                            {{ form.errors.type }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="employeeId" class="form-label">Employee ID or Email</label>
                        <input type="text" v-model="form.email" class="form-control form-control-lg"
                            :class="{ 'is-invalid': !!form.errors.email }" id="employeeId" aria-describedby="emailHelp"
                            required>

                        <div class="invalid-feedback">
                            {{ form.errors.email }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" v-model="form.password" class="form-control form-control-lg" id="password" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="button" @click="login" class="btn btn-primary btn-lg">Sign In</button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <a href="#" class="text-muted">Forgot Password?</a>
                </div>
            </div>
        </div>
    </div>
</template>





<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    type: null,
    email: 'computer@gmail.com',
    password: '12345678'
})
const login = () => {
    try {

        /*
          email: 'bookmanbd@outlook.com',
    password: '12345'
    */

        form.post(route('login.post'))



    } catch (error) {
        console.error(error);
    }
}
</script>

<style lang="scss" scoped>
.login-container {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    /* Light gray background */
}

.login-card {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>