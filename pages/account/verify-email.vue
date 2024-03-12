<template>
    <section class="h-[80vh] flex items-center justify-center px-4">
        <form @submit.prevent="verifyEmailHandler" class="max-w-lg w-full">
            <h1 class="mb-3 text-3xl font-bold">Email verification!</h1>
            <Processing v-if="processing" :text="processing" />
            <Failed v-if="failed" :text="failed" />
            <Success v-if="success" :text="success" />
            <p class="mb-3">To verify your email, just click the button below to receive the email and in the email click.</p>
            <Button text="Resend verification" />
        </form>
    </section>
</template>

<script setup>
    const errors = ref({
        email: null,
        count: 0
    });
    const processing = ref("");
    const failed = ref("");
    const success = ref("");

    const api = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_credientials');

    const verifyEmailHandler = async () => {
        processing.value = "Processing...";
        failed.value = "";
        success.value = "";
        try{
            const data = await $fetch(`${api}/api/verify-email`, {
                method: "POST",
                headers: {
                    'Authorization': 'Bearer '+cookie.value
                }
            });
            if(data.message){
                success.value = data.message;
            }
        }catch(e){
            failed.value = "Something went wrong";
        }
        processing.value = "";
    }
</script>