export default defineNuxtRouteMiddleware((to, from) => {
    const cookie = useCookie('auth_credientials');
    if(cookie.value){
        return navigateTo('/dashboard');
    }else{
        
    }
})