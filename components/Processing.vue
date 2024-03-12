<template>
    <section class="fixed bottom-3 max-w-[300px] w-full left-3 p-6 rounded-lg bg-black text-white flex items-center shadow-lg z-30">
        <img src="https://api.iconify.design/svg-spinners:270-ring-with-bg.svg?color=%2317e83a" width="30" alt="Spinner">
        <p class="ml-2 text-lg price font-semibold">{{ text }}</p>
    </section>
</template>
<script setup>
    defineProps(['text'])
</script>