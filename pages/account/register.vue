<template>
    <section class="h-[80vh] flex items-center justify-center px-4">
        <form @submit.prevent="registerHandler" class="max-w-lg w-full">
            <h1 class="mb-3 text-3xl font-bold">Create new account!</h1>
            <Processing v-if="processing" :text="processing" />
            <Failed v-if="failed" :text="failed" />
            <div class="w-full mb-3">
                <Input type="text" v-model="name" placeholder="Full Name" required />
                <Error v-if="errors.name" :text="errors.name" />
            </div>
            <div class="w-full mb-3">
                <Input type="email" v-model="email" placeholder="Email Address" required />
                <Error v-if="errors.email" :text="errors.email" />
            </div>
            <div class="w-full mb-3">
                <Input type="password" v-model="password" placeholder="Password" required />
                <Error v-if="errors.password" :text="errors.password" />
            </div>
            <div class="w-full mb-3">
                <Input type="password" v-model="password_confirm" placeholder="Confirm Password" required />
                <Error v-if="errors.password_confirm" :text="errors.password_confirm" />
            </div>
            <Button text="Register" />
        </form>
    </section>
</template>

<script setup>
    const name = ref("");
    const email = ref("");
    const password = ref("");
    const password_confirm = ref("");
    const errors = ref({
        name: null,
        email: null,
        password: null,
        password_confirm: null,
        count: 0
    });
    const processing = ref("");
    const failed = ref("");

    const api = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_credientials');

    definePageMeta({
        middleware: ['guest']
    });

    const registerHandler = async () => {
        processing.value = "Creating account...";
        failed.value = "";
        errors.value = {
            name: null,
            email: null,
            password: null,
            password_confirm: null,
            count: 0
        }
        if(!name.value){
            errors.value.name = "Name is required!";
            errors.value.count += 1;
        }
        if(!email.value){
            errors.value.email = "Email is required!";
            errors.value.count += 1;
        }
        if(!password.value){
            errors.value.password = "Password is required!";
            errors.value.count += 1;
        }
        if(!password_confirm.value){
            errors.value.password_confirm = "Confirm Password is required!";
            errors.value.count += 1;
        }
        if(password_confirm.value != password.value){
            errors.value.password = "Password and Confirm Password does not match!";
            errors.value.count += 1;
        }
        if(errors.value.count == 0){
            try{
                const data = await $fetch(`${api}/api/register`, {
                    method: "POST",
                    body: {
                        name: name.value,
                        email: email.value,
                        password: password.value,
                        password_confirmation: password_confirm.value
                    }
                });
                if(data){
                    cookie.value = data.token;
                    navigateTo('/account/verify-email');
                }
            }catch(e){
                failed.value = "Something went wrong!";
            }
        }
        processing.value = "";
    }
</script>