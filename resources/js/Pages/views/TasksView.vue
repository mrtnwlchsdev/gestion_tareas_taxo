<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { ref, computed, onMounted } from "vue";

// Componentes
import Navigation from "@/Pages/components/Navigation.vue";
import TaskCard from "@/Pages/components/TaskCard.vue";

// Importación de la store de pinia
import { useTasksStore } from "@/store";

const tasksStore = useTasksStore();

const props = defineProps({
    tasks_pagination: {
        type: Object,
        required: true,
    },
    all_tasks: {
        type: Object,
        required: true,
    },
});

// Mensajes de alerta durante el proceso de eliminación de una tarea
const error_message = ref("");

// Funcion que permite limpiar el mensaje de error mostrado al usuario
const resetMessage = () => {
    setTimeout(() => {
        error_message.value = "";
    }, 3000);
};

const favorites = ref(false);
const search = ref("");

const button_label = ref("Nueva tarea");

// Enlaces de paginacion
const links = ref([]);

const filterFavorites = (param) => {
    favorites.value = param;
};

// Recepción del evento emitido desde el componente TaskCard si no se puede eliminar una tarea
const onUpdateTaskError = (param) => {
    error_message.value = param;
    resetMessage();
};

// Filtrar tareas por etiquetas
const onFilterTag = (param) => {
    search.value = param;
};

const filterTasks = computed(() => {
    if (search.value) {
        return props.all_tasks.filter((item) => {
            return (
                item.task_title
                    .toLowerCase()
                    .includes(search.value.toLowerCase()) ||
                item.task_description
                    .toLowerCase()
                    .includes(search.value.toLowerCase()) ||
                // Se filtran las tareas por etiquetas
                item.tags.split(",").includes(search.value.toLowerCase())
            );
        });
    } else if (favorites.value) {
        return props.all_tasks.filter((item) => {
            return item.favorite_task == 1;
        });
    } else {
        return tasksStore.getTasks;
    }
});

onMounted(async () => {
    links.value = props.tasks_pagination.links;
    tasksStore.setTasks(props.tasks_pagination.data);
});
</script>

<template>
    <main>
        <header>
            <Navigation :login="true" />
        </header>
        <article class="container mt-[100px] mx-auto py-5 px-3">
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

            <!-- Buscador de tareas -->
            <section class="flex justify-center items-center w-full mt-10">
                <input
                    type="text"
                    class="w-full py-3 px-4 shadow-lg rounded-full text-sm text-black bg-white focus:outline-none"
                    placeholder="Buscar tarea"
                    v-model="search"
                />
            </section>

            <section class="flex gap-3">
                <button class="favorite_button" @click="filterFavorites(true)">
                    Favoritas
                </button>
                <button class="favorite_button" @click="filterFavorites(false)">
                    Todas
                </button>
            </section>

            <section
                class="relative grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-10"
            >
                <TaskCard
                    v-for="(item, index) in filterTasks"
                    :data="item"
                    :key="index"
                    @filterTag="onFilterTag"
                    @updateTaskError="onUpdateTaskError"
                />

                <article class="absolute bottom-0 right-0"></article>
            </section>
        </article>

        <!-- Diseño de la paginación, permitiendo mostra máximo 9 tareas por página -->
        <section v-if="all_tasks.length > 9 && !search">
            <ul
                class="absolute bottom-10 right-10 flex justify-center items-center gap-2"
            >
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

<style lang="scss" scoped>
.favorite_button {
    @apply text-center mt-6 py-2 px-6 rounded-md text-sm text-white bg-black duration-200 border-solid border-2 border-transparent hover:bg-white hover:text-black hover:border-black;
}
</style>
