<template>
    <button type="submit" class="w-fit py-2 px-4 inline-block bg-indigo-600 text-white7 text-white font-semibold rounded-md">
        {{ text }}
    </button>
</template>

<script setup>
    defineProps(['text'])
</script>