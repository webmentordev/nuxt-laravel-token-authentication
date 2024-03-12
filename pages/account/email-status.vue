<template>
    <section class="h-[80vh] flex items-center justify-center px-4">
        <div v-if="status == 'success'">
            <h1 class="mb-3 text-3xl font-bold">Congratulation!</h1>
            <p class="mb-3">Your email has been verified!</p>
        </div>
        <div v-else-if="status == 'failed'">
            <h1 class="mb-3 text-3xl font-bold text-red-600">Verification Failed!</h1>
        </div>
        <div class="flex items-center" v-else>
            <img src="https://api.iconify.design/svg-spinners:270-ring-with-bg.svg?color=%2317e83a" width="40" alt="Spinner">
            <h1 class="ml-3 text-3xl font-bold">Processing verification...</h1>
        </div>
    </section>
</template>

<script setup>
    const route = useRoute().query;
    const api = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_credientials');
    const status = ref('loading');
    try{
        const data = await $fetch(`${api}/api/email-verification/${route.status}/${route.notify}`, {
            method: "POST",
            headers: {
                'Authorization': 'Bearer '+cookie.value
            }
        });
        if(data.message){
            status.value = "success";
        }
    }catch(e){
        status.value = "failed";
    }
</script>