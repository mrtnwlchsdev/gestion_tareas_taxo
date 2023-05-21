<script setup>
import { ref, watchEffect } from "vue";

// Ruta del evento para la conexión con el backend
import routes from "@/routes";

// Componentes
import Navigation from "@/Pages/components/Navigation.vue";

// API para realizar las peticiones al backend
import api from "@/api";

// Importación de la store de pinia
import { useTasksStore } from "@/store";

const tasksStore = useTasksStore();

// Nombre y descripción de la tarea
const task_title = ref("");
const task_description = ref("");

// Mensaje de error en la creación de la tarea
const error_message = ref("");
// Mensaje de exito en la creacion de la tarea
const success_message = ref("");

// Tag digitado
const tag = ref("");

// Arreglo de tags
const tags = ref([]);

const resetMessage = () => {
    setTimeout(() => {
        error_message.value = "";
        success_message.value = "";
    }, 3000);
};

// Añadir un nuevo tag
const addTag = () => {
    if (tags.value.length === 4) return;
    if (tag.value && !tags.value.includes(tag.value))
        tags.value.push(tag.value.toLowerCase());

    tag.value = "";
};

// Eliminar un tag
const deleteTag = (index) => {
    tags.value = tags.value.filter((tag) => tag !== tags.value[index]);
};

// Funcion que permite crear una nueva tarea
const createTask = async () => {
    // Validar que se haya agregado al menos un tag
    if (tags.value.length === 0) {
        error_message.value = "Se debe agregar al menos un tag a la tarea";
        resetMessage();
        return;
    }

    // Validar que el campo título no este vacio
    if (!task_title.value) {
        error_message.value = "El campo título no puede estar vacio";
        resetMessage();
        return;
    }

    await api.post(routes.create_task, {
        user_id:
            tasksStore.getUserId !== 0
                ? tasksStore.getUserId
                : localStorage.getItem("user_id"),
        description: task_description.value.trim(),
        title: task_title.value.trim(),
        tags: tags.value.join(","),
    });

    success_message.value = "Tarea creada con exito";
    task_description.value = "";
    task_title.value = "";
    tag.value = "";
    tags.value = [];
    resetMessage();
};

// Funcion que evita que los mensajes de alerta al usuario se sobrepongan
watchEffect(() => {
    if (success_message.value) error_message.value = "";
    if (error_message.value) success_message.value = "";
});
</script>

<template>
    <main>
        <header>
            <Navigation :login="true" />
        </header>
        <article class="max-w-screen-md mx-auto mt-20">
            <section class="px-4 py-10">
                <!-- Status message -->
                <article
                    v-if="success_message || error_message"
                    class="mb-10 -4 bg-light-grey rounded-md shadow-lg p-4 text-center"
                >
                    <p v-if="success_message" class="text-green-500">
                        {{ success_message }}
                    </p>
                    <p v-if="error_message" class="text-red-500">
                        {{ error_message }}
                    </p>
                </article>

                <!-- Formulario para la creación de tareas -->
                <section
                    class="p-8 flex items-start bg-light-grey rounded-md shadow-lg"
                >
                    <form
                        class="flex flex-col gap-y-5 w-full"
                        autocomplete="off"
                    >
                        <header>
                            <h1 class="text-2xl text-black">Registrar tarea</h1>
                        </header>

                        <section class="flex flex-col">
                            <label
                                for="tag-name"
                                class="mb-1 text-md text-black"
                            >
                                Tags
                            </label>
                            <section
                                class="flex items-center rounded-full py-1 px-2 w-1/4 bg-white"
                            >
                                <input
                                    class="bg-white text-gray-500 w-full focus:outline-none"
                                    type="text"
                                    id="tag-name"
                                    maxlength="15"
                                    v-model="tag"
                                    :disabled="tags.length === 4"
                                />
                                <span
                                    :class="[
                                        tags.length === 4
                                            ? 'text-light-grey cursor-default'
                                            : 'text-black',
                                        'material-icons cursor-pointer bg-white select-none',
                                    ]"
                                    title="Añadir tag"
                                    @click="addTag"
                                >
                                    add
                                </span>
                            </section>
                            <section
                                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-3"
                            >
                                <span
                                    v-for="(item, index) in tags"
                                    class="flex items-center py-1 justify-between bg-white px-2 rounded-full shadow-md"
                                    :key="index"
                                >
                                    <span class="leading-8 truncate">{{
                                        item
                                    }}</span>
                                    <span
                                        class="material-icons text-[23px] cursor-pointer"
                                        title="Eliminar"
                                        @click="deleteTag(index)"
                                    >
                                        delete
                                    </span>
                                </span>
                            </section>
                        </section>

                        <section class="flex flex-col">
                            <label
                                for="task-name"
                                class="mb-1 text-md text-black"
                            >
                                Titulo
                            </label>
                            <input
                                class="p-2 text-gray-500 focus:outline-none"
                                type="text"
                                id="task-name"
                                maxlength="100"
                                v-model="task_title"
                            />
                        </section>
                        <section class="flex flex-col">
                            <label
                                for="task_description"
                                class="mb-1 text-md text-black"
                            >
                                Descripción
                            </label>
                            <textarea
                                class="w-full min-h-[150px] p-2 text-gray-500 focus:outline-none resize-none"
                                id="task_description"
                                maxlength="500"
                                v-model="task_description"
                            ></textarea>
                        </section>
                        <button
                            type="button"
                            class="mt-6 py-2 px-6 rounded-md text-sm text-white bg-black w-full duration-200 border-solid border-2 border-transparent hover:bg-white hover:text-black hover:border-black"
                            @click="createTask"
                        >
                            Guardar tarea
                        </button>
                    </form>
                </section>
            </section>
        </article>
    </main>
</template>

<style></style>
