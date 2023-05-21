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

// Mensajes de alerta en la actualizacion de la tarea
const error_message = ref("");
const success_message = ref("");

// Funcion que permite limpiar el mensaje de error mostrado al usuario
const resetMessage = () => {
    setTimeout(() => {
        error_message.value = "";
        success_message.value = "";
    }, 3000);
};

// Marcar una tarea como completada
const completeTask = async () => {
    completed_task.value = !completed_task.value;
    try {
        await api.put(routes.update_state_task, {
            id: props.data.id,
        });
        success_message.value =
            "La tarea ha sido marcada como completada correctamente";
        resetMessage();
    } catch (error) {
        error_message.value = "Ocurrió un error al actualizar la tarea";
        resetMessage();
    }
};
</script>

<template>
    <main>
        <header>
            <Navigation :login="true" />
        </header>

        <section
            class="container mt-[200px] mx-auto px-10 pb-10 shadow-lg relative xs:w-[90%] sm:w-[80%] md:w-[70%] lg:w-[60%] xl:w-[50%]"
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
                @click="completeTask"
                :class="[
                    data.completed_task || completed_task
                        ? 'text-green-500 hidden'
                        : 'text-gray-400',
                    'absolute bottom-5 right-5 material-icons cursor-pointer text-right duration-200 hover:text-green-500',
                ]"
                title="Marcar como completada"
            >
                check_circle
            </span>
        </section>
        <article
            v-if="error_message || success_message"
            class="w-1/2 mt-20 mx-auto p-4 rounded-md bg-light-grey shadow-lg"
        >
            <p v-if="success_message" class="text-green-500 text-center">
                {{ success_message }}
            </p>
            <p v-if="error_message" class="text-red-500 text-center">
                {{ error_message }}
            </p>
        </article>
    </main>
</template>
