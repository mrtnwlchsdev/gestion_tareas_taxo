<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { ref, onMounted } from "vue";

// Componentes
import Navigation from "@/Pages/components/Navigation.vue";
import TaskCard from "@/Pages/components/TaskCard.vue";

// Importación de la store de pinia
import { useTasksStore } from "@/store";

const tasksStore = useTasksStore();

const props = defineProps({
    tasks: {
        type: Object,
        required: true
    }
})

// Mensajes de alerta durante el proceso de eliminación de una tarea
const error_message = ref("");

// Funcion que permite limpiar el mensaje de error mostrado al usuario
const resetMessage = () => {
    setTimeout(() => {
        error_message.value = "";
    }, 3000);
};

const button_label = ref("Nueva tarea");

// Enlaces de paginacion
const links = ref([]);

// Recepción del evento emitido desde el componente TaskCard si no se puede eliminar una tarea
const onUpdateTaskError = (param) => {
    error_message.value = param;
    resetMessage();
};

onMounted(async () => {
    links.value = props.tasks.links;
    tasksStore.setTasks(props.tasks.data);
});
</script>

<template>
    <main>
        <header>
            <Navigation :login="true" />
        </header>
        <article class="container mt-[100px] mx-auto py-5">
            <article
                v-if="error_message"
                class="w-1/2 mb-10 mx-auto p-4 rounded-md bg-light-grey shadow-lg"
            >
                <p class="text-red-500 text-center">
                    {{ error_message }}
                </p>
            </article>
            <Link
                href="/tasks/create"
                type="button"
                class="text-center mt-6 py-2 px-6 rounded-md text-sm text-white bg-black duration-200 border-solid border-2 border-transparent hover:bg-white hover:text-black hover:border-black"
            >
                {{ button_label }}
            </Link>

            <section
                class="relative grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-10"
            >
                <TaskCard
                    v-for="(item, index) in tasksStore.getTasks"
                    :data="item"
                    :key="index"
                    @updateTaskError="onUpdateTaskError"
                />

                <article class="absolute bottom-0 right-0">
                </article>
            </section>
        </article>

        <!-- Diseño de la paginación, permitiendo mostra máximo 9 tareas por página -->
        <section v-if="tasksStore.getTasks.length > 9">
            <ul class="absolute bottom-10 right-10 flex justify-center items-center gap-2">
                <li
                    v-for="(item, index) in links"
                    :key="index"
                    class="cursor-pointer"
                >
                    <Link
                        v-if="Math.abs(item.label)"
                        :href="item.url"
                        class="py-2 px-4 rounded-md text-sm text-white bg-black duration-200 border-solid border-2 border-transparent hover:bg-white hover:text-black hover:border-black"
                    >
                        {{ item.label }}
                    </Link>
                </li>
            </ul>
        </section>
    </main>
</template>

<style></style>
