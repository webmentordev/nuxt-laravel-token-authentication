<template>
    <section class="fixed bottom-3 max-w-[350px] w-full left-3 p-6 rounded-lg bg-black text-white flex items-center shadow-lg z-30">
        <img src="https://api.iconify.design/radix-icons:cross-circled.svg?color=%23f42525" width="30" alt="Spinner">
        <p class="ml-2 text-lg price font-semibold">{{ text }}</p>
    </section>
</template>
<script setup>
    defineProps(['text'])
</script>