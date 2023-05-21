<script setup>
import { Link } from "@inertiajs/inertia-vue3";

import { ref, computed } from "vue";

// Ruta del evento para la conexión con el backend
import routes from "@/routes";

// API para realizar las peticiones al backend
import api from "@/api";

// Importación de la store de pinia
import { useTasksStore } from "@/store";

const tasksStore = useTasksStore();

const emit = defineEmits(["updateTaskError"]);

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});

// Nuevos datos obtenidos de la edición de la tarea
const task_title = ref("");
const task_description = ref("");

const favorite_task = ref(false);
const editing = ref(false);
const task_id = ref(0);

// Marcar una tarea como favorita
const favoriteTask = async () => {
    favorite_task.value = !favorite_task.value;
    try {
        await api.put(routes.update_favorite_task, {
            id: props.data.id,
        });
    } catch (error) {
        emit("updateTaskError", "Ocurrió un error al actualizar la tarea");
    }
};

// Eliminar una tarea
const deleteTask = async () => {
    tasksStore.deleteTask(props.data.id);

    try {
        await api.post(routes.delete_task, {
            id: props.data.id,
        });
    } catch (error) {
        emit("updateTaskError", "Ocurrió un error al eliminar la tarea");
    }
};

// Editar el titulo y la descripción de una tarea
const editTask = (id) => {
    editing.value = !editing.value;
    task_id.value = id;
};

// Cancelar la edición de una tarea
const cancelEdit = () => {
    editing.value = !editing.value;
    task_id.value = 0;
};

// Guardar los cambios realizados en una tarea
const saveTask = async (id) => {
    if (!task_title.value) {
        emit("updateTaskError", "El título de la tarea es obligatorio");
        return;
    }

    try {
        await api.put(routes.save_task, {
            description: task_description.value,
            title: task_title.value,
            id: props.data.id,
        });

        tasksStore.updateTasks(task_description.value, task_title.value, id);
    } catch (error) {
        emit("updateTaskError", "Ocurrió un error al actualizar la tarea");
    }

    editing.value = !editing.value;
    task_id.value = 0;
};

// Obtener las etiquetas de una tarea en formato array en caso de que estas vengan de base de datos como formato string
const tags = computed(() => {
    return props.data.tags.split(",");
});
</script>

<template>
    <section class="flex flex-col gap-2 shadow-lg p-3 rounded-lg truncate">
        <header class="flex justify-between items-center">
            <section>
                <input
                    v-if="editing && data.id == task_id"
                    type="text"
                    class="p-1 bg-light-grey text-gray-500 focus:outline-none"
                    v-model="task_title"
                />
                <Link
                    v-else
                    class="text-2xl truncate"
                    :href="'/tasks/' + data.id"
                    >{{ data.task_title }}</Link
                >
            </section>
            <article class="flex justify-end select-none">
                <article>
                    <section v-if="editing && !data.completed_task">
                        <span
                            @click="cancelEdit"
                            class="material-icons cursor-pointer"
                            title="Cancelar"
                        >
                            undo
                        </span>
                        <span
                            @click="saveTask(data.id)"
                            class="material-icons cursor-pointer"
                            title="Guardar"
                        >
                            save
                        </span>
                    </section>
                    <section v-else-if="!editing && !data.completed_task">
                        <span
                            @click="editTask(data.id)"
                            class="material-icons cursor-pointer"
                            title="Editar"
                        >
                            edit
                        </span>
                        <span
                            @click="deleteTask"
                            class="material-icons cursor-pointer"
                            title="Eliminar"
                        >
                            delete
                        </span>
                    </section>
                </article>
                <span
                    :class="[
                        data.favorite_task || favorite_task
                            ? 'text-red-500'
                            : 'text-black',
                        'material-icons ml-3 cursor-pointer',
                    ]"
                    @click="favoriteTask"
                >
                    favorite
                </span>
            </article>
        </header>

        <article class="flex gap-3 text-sm">
            <span
                v-for="(item, index) in tags"
                class="bg-light-grey shadow-md py-1 px-2 cursor-pointer text-blue-500"
                :key="index"
            >
                {{ item }}
            </span>
        </article>

        <section class="mt-5">
            <input
                v-if="editing && data.id == task_id"
                type="text"
                class="w-full p-1 bg-light-grey text-gray-500 focus:outline-none"
                v-model="task_description"
            />
            <article v-else class="overflow-hidden truncate">
                {{ data.task_description }}
            </article>
        </section>
        <span
            v-if="data.completed_task"
            @click="completeTask"
            :class="[
                data.completed_task || completed_task
                    ? 'text-green-500 cursor-auto'
                    : 'text-gray-400 cursor-pointer',
                'material-icons text-right duration-200 hover:text-green-500',
            ]"
            title="Completar"
        >
            check_circle
        </span>
    </section>
</template>
