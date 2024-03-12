<template>
    <section class="h-[80vh] flex items-center justify-center px-4">
        <form @submit.prevent="loginHandler" class="max-w-lg w-full">
            <h1 class="mb-3 text-3xl font-bold">Login your account!</h1>
            <Processing v-if="processing" :text="processing" />
            <Failed v-if="failed" :text="failed" />
            <div class="w-full mb-3">
                <Input type="email" v-model="email" placeholder="Email Address" />
                <Error v-if="errors.email" :text="errors.email" />
            </div>
            <div class="w-full mb-3">
                <Input type="password" v-model="password" placeholder="Password" />
                <Error v-if="errors.password" :text="errors.password" />
            </div>
            <Button text="Login" class="mb-3" />
            <p class="text-center">Forgot your account password? <NuxtLink to="/account/reset-password" class="underline text-indigo-600">Reset now</NuxtLink></p>
        </form>
    </section>
</template>

<script setup>
    const email = ref("");
    const password = ref("");
    const errors = ref({
        email: null,
        password: null,
        count: 0
    });
    const processing = ref("");
    const failed = ref("");

    const api = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_credientials');

    definePageMeta({
        middleware: ['guest']
    });

    const loginHandler = async () => {
        processing.value = "Logging in...";
        failed.value = "";
        errors.value = {
            email: null,
            password: null,
            count: 0
        }
        if(!email.value){
            errors.value.email = "Email is required!";
            errors.value.count += 1;
        }
        if(!password.value){
            errors.value.password = "Password is required!";
            errors.value.count += 1;
        }
        if(errors.value.count == 0){
            try{
                const data = await $fetch(`${api}/api/login`, {
                    method: "POST",
                    body: {
                        email: email.value,
                        password: password.value
                    }
                });
                if(data){
                    cookie.value = data.token;
                    navigateTo('/dashboard');
                }
            }catch(e){
                if(e.status == 401){
                    failed.value = "Bad login credientials";
                }
            }
        }
        processing.value = "";
    }
</script>