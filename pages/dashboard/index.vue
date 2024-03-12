<template>
    <section class="max-w-6xl w-full m-auto py-12">
        <h1 class="text-4xl mb-6">Dashboard 👋</h1>
    </section>
</template>

<script setup>
    definePageMeta({
        middleware: ['auth']
    })
</script>