<template>
    <section class="max-w-6xl w-full m-auto py-12">
        <h1 class="text-4xl mb-6">Welcome to Nuxt 3 and Laravel {{ version }}</h1>
    </section>
</template>

<script setup>
    const version = ref(null);
    const api = useRuntimeConfig().public.api;

    const data = await $fetch(`${api}`);
    version.value = data.version;
</script>