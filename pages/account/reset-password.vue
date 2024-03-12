<template>
    <section class="h-[80vh] flex items-center justify-center px-4">
        <form @submit.prevent="forgotPasswordHandler" class="max-w-lg w-full">
            <h1 class="mb-3 text-3xl font-bold">Forgot password!</h1>
            <Processing v-if="processing" :text="processing" />
            <Failed v-if="failed" :text="failed" />
            <Success v-if="success" :text="success" />
            <p class="mb-3">Forgot your password? No problem. Just enter your correct email address and we will email you a password reset link that will allow you to choose a new one.</p>
            <div class="w-full mb-3">
                <Input type="email" v-model="email" placeholder="Your email address" />
                <Error v-if="errors.email" :text="errors.email" />
            </div>
            <Button text="Rest Password" />
        </form>
    </section>
</template>

<script setup>
    const email = ref("");
    const errors = ref({
        email: null,
        count: 0
    });
    const processing = ref("");
    const failed = ref("");
    const success = ref("");

    const api = useRuntimeConfig().public.api;

    definePageMeta({
        middleware: ['guest']
    });

    const forgotPasswordHandler = async () => {
        processing.value = "Processing...";
        failed.value = "";
        success.value = "";
        errors.value = {
            email: null,
            count: 0
        }
        if(!email.value){
            errors.value.email = "Email is required!";
            errors.value.count += 1;
        }
        if(errors.value.count == 0){
            try{
                const data = await $fetch(`${api}/api/reset-request`, {
                    method: "POST",
                    body: {
                        email: email.value
                    }
                });
                if(data.message){
                    success.value = data.message;
                }
            }catch(e){
                failed.value = "Something went wrong";
            }
        }
        processing.value = "";
    }
</script>