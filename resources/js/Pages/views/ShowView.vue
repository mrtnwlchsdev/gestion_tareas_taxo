<script setup>
import { ref } from "vue";

// Componentes
import Navigation from "@/Pages/components/Navigation.vue";

// Ruta del evento para la conexión con el backend
import routes from "@/routes";

// API para realizar las peticiones al backend
import api from "@/api";

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

const completed_task = ref(false);

// Marcar una tarea como completada
const completeTask = async () => {
    completed_task.value = !completed_task.value;
    try {
        await api.put(routes.update_state_task, {
            id: props.data.id,
        });
    } catch (error) {
        emit("updateTaskError", "Ocurrió un error al actualizar la tarea");
    }
};
</script>

<template>
    <main>
        <header>
            <Navigation :login="true" />
        </header>

        <section
            class="container w-[50%] mx-auto mt-[200px] p-10 shadow-lg relative"
        >
            <header>
                <h1 class="text-2xl break-all">
                    {{ data.task_title }}
                </h1>
            </header>
            <article class="mt-5 flex gap-3 text-sm">
                <span
                    v-for="(item, index) in data.tags.split(',')"
                    class="bg-light-grey shadow-md py-1 px-2 text-blue-500"
                    :key="index"
                >
                    {{ item }}
                </span>
            </article>
            <p class="mt-10 pb-[100px] break-all">
                {{ data.task_description }}
            </p>
            <span
                :class="[
                    data.favorite_task || favorite_task
                        ? 'text-red-500'
                        : 'text-black',
                    'material-icons absolute top-5 right-5',
                ]"
                @click="favoriteTask"
            >
                favorite
            </span>
            <span
                @click="completeTask"
                :class="[data.completed_task || completed_task ? 'text-green-500' : 'text-gray-400' , 'absolute bottom-5 right-5 material-icons cursor-pointer text-right duration-200 hover:text-green-500']"
                title="Completar"
            >
                check_circle
            </span>
        </section>
    </main>
</template>
