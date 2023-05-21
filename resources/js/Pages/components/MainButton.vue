<script setup>
const props = defineProps({
    button_label: {
        type: String,
        default: "",
    },
});

const emit = defineEmits(["auth"]);
</script>

<template>
    <button
        @click="emit('auth')"
        type="button"
        class="text-center mt-6 py-2 px-6 rounded-md text-sm text-white bg-black duration-200 border-solid border-2 border-transparent hover:bg-white hover:text-black hover:border-black"
    >
        {{ button_label }}
    </button>
</template>
