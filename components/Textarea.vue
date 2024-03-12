<template>
    <textarea cols="30" rows="4" class="w-full bg-white rounded border border-gray-300 focus:border-black focus:ring-4 focus:ring-black/10 text-base outline-none text-black py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
      :value="props.modelValue"
      @input="emit('update:modelValue', $event.target.value)"></textarea>
  </template>

<script setup>
    const props = defineProps(['modelValue'])
    const emit = defineEmits(['update:modelValue'])
</script>