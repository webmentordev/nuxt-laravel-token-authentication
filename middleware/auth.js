export default defineNuxtRouteMiddleware(async (to, from) => {
    const cookie = useCookie('auth_credientials');
    const config = useRuntimeConfig();
    if(cookie.value){
        try{
            const data = await $fetch(`${config.public.api}/api/user`, {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer '+cookie.value
                }
            });
            if(!data.email_verified_at){
                return navigateTo('/account/verify-email');
            }
        }catch(e){
            cookie.value = null;
            return navigateTo('/account/login');
        }
    }else{
        return navigateTo('/account/login');
    }
})