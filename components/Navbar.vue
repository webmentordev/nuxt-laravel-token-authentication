<template>
    <nav class="w-full top-0 left-0 sticky border-b border-gray-200 bg-white">
        <div class="max-w-6xl m-auto flex items-center justify-between py-3 px-4">
            <NuxtLink to="/">
                <img src="https://api.iconify.design/logos:laravel.svg?color=%23fe1616" alt="Laravel Logo" width="40">
            </NuxtLink>
            <ul class="font-semibold flex items-center">
                <NuxtLink class="px-6" to="/">Home</NuxtLink>
                <div v-if="is_auth" class="flex items-center">
                    <NuxtLink class="px-6" to="/dashboard">Dashboard</NuxtLink>
                    <form @submit.prevent="logoutHandler" method="post">
                        <Button text="Logout" />
                    </form>
                </div>
                <div class="flex items-center" v-else>
                    <NuxtLink class="px-6" to="/account/login">Login</NuxtLink>
                    <NuxtLink class="px-6" to="/account/register">Register</NuxtLink>
                </div>
            </ul>
        </div>
    </nav>
</template>

<script setup>
    const is_auth = ref(false);
    const processing = ref("");
    const failed = ref("");

    const api = useRuntimeConfig().public.api;
    const cookie = useCookie('auth_credientials');

    watchEffect(() => {
        if(cookie.value){
            is_auth.value = true;
        }else{
            is_auth.value = false;
        }
    })

    const logoutHandler = async () => {
        processing.value = "Logging out...";
        failed.value = "";
        try{
            const data = await $fetch(`${api}/api/logout`, {
                method: "DELETE",
                headers: {
                    'Authorization': 'Bearer '+cookie.value
                }
            });
            if(data.message){
                cookie.value = null;
                navigateTo('/account/login');
            }
        }catch(e){
            failed.value = "Something went wrong!";
        }
        processing.value = "";
    }
</script>