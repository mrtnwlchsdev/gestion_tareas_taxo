<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { computed } from "vue";

// Ruta del evento para la conexión con el backend
import routes from "@/routes";

// API para realizar las peticiones al backend
import api from "@/api";

const props = defineProps({
    login: {
        type: Boolean,
        default: false,
    },
});

// Ruta de inicio configurada dependiendo de si el usuario está logueado o no
const inicio = computed(() => {
    if (props.login) {
        return "/tasks";
    } else {
        return "/";
    }
});

const logout = async () => {
    await api.get(routes.logout);
};
</script>

<template>
    <header class="absolute top-0 w-full bg-black text-white">
        <nav
            class="container py-5 px-4 m-auto flex flex-col gap-4 items-center sm:flex-row"
        >
            <div class="flex items-center gap-x-4">
                <h1 class="text-lg text-center">Gestión de tareas</h1>
            </div>
            <ul class="flex flex-1 justify-end gap-x-10">
                <Link :href="inicio"> Inicio </Link>
                <Link v-if="!login" href="/login"> Login </Link>
                <Link v-else href="/login" @click="logout"> Salir </Link>
            </ul>
        </nav>
    </header>
</template>
