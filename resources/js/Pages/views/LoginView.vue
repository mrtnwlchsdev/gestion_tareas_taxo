<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

// Ruta del evento para la conexión con el backend
import routes from "@/routes";

// Componentes
import MainButton from "@/Pages/components/MainButton.vue";
import Navigation from "@/Pages/components/Navigation.vue";

// API para realizar las peticiones al backend
import api from "@/api";

// Importación de la store de pinia
import { useTasksStore } from "@/store";

const tasksStore = useTasksStore();

// Credenciales de logueo
const email = ref("");
const password = ref("");

// Mensaje de error en el registro
const error_message = ref("");

const button_label = ref("Iniciar sesión");

const resetMessage = () => {
    setTimeout(() => {
        error_message.value = "";
    }, 3000);
};

// Funcion que permite loguear al usuario
const onLogin = async () => {
    // Validar que los campos no esten vacios
    if (!email.value || !password.value) {
        error_message.value = "Todos los campos son obligatorios";
        resetMessage();
        return;
    }

    // Validar que el correo contenga un formato valido
    if (!tasksStore.getRegex.test(email.value)) {
        error_message.value =
            "El correo ingresado no contiene un formato valido";
        resetMessage();
        return;
    }

    const response = await api.post(routes.login, {
        email: email.value.trim(),
        password: password.value.trim(),
    });

    if (response.status === 400) {
        error_message.value = response.data.message;
        resetMessage();
        return;
    } else {
        // Redireccionar al usuario a la vista de tareas cuando este ha iniciado sesión
        // ** Trate de usar el enrutamiento desde el controlador pero no fue posible, asi que lo hice desde el frontend
        window.location.href = "/tasks";

        email.value = "";
        password.value = "";
        resetMessage();
        return;
    }
};
</script>

<template>
    <header>
        <Navigation />
    </header>
    <article class="max-w-screen-sm mx-auto mt-20">
        <!-- Formulario de logueo -->
        <section class="px-4 py-10">
            <!-- Alerta de error en el logueo -->
            <article
                v-if="error_message"
                class="mb-10 p-4 rounded-md bg-light-grey shadow-lg"
            >
                <p class="text-red-500 text-center">
                    {{ error_message }}
                </p>
            </article>

            <form
                method="POST"
                class="p-8 flex flex-col bg-light-grey rounded-md shadow-lg"
                autocomplete="off"
                @submit.prevent="login"
            >
                <header>
                    <h1 class="text-3xl text-black text-center mb-4">
                        <svg
                            width="86"
                            height="22"
                            viewBox="0 0 86 22"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M18.6492 21.0286H22.3931L29.752 7.67142L37.1109 21.0286H40.8547L29.752 0.875977L18.6492 21.0286ZM18.862 13.1608V9.50146H11.1769V1.39209H7.68508V9.50146H0V13.1608H7.68508V21.0287H11.1769V13.1608H18.862ZM58.657 1.42529L51.7888 8.62285L44.9207 1.42529L42.4515 4.01283L49.3197 11.2104L42.4515 18.4079L44.9207 20.9955L51.7888 13.7979L58.657 20.9955L61.1261 18.4079L54.258 11.2104L61.1261 4.01283L58.657 1.42529ZM63.7982 11.3312C63.7982 5.93153 67.9901 1.53857 73.1427 1.53857C78.2953 1.53857 82.4872 5.93153 82.4872 11.3312C82.4872 16.7309 78.2953 21.1239 73.1427 21.1239C67.9901 21.1239 63.7982 16.7309 63.7982 11.3312ZM67.0405 11.3312C67.0405 14.8574 69.778 17.7262 73.1427 17.7262C76.5075 17.7262 79.245 14.8574 79.245 11.3312C79.245 7.80508 76.5075 4.9363 73.1427 4.9363C69.778 4.9363 67.0405 7.80508 67.0405 11.3312ZM84.2487 5.74287C85.2394 5.74287 86 4.94533 86 3.92938C86 2.93524 85.2394 2.1377 84.2487 2.1377C83.2691 2.1377 82.4872 2.93524 82.4872 3.92938C82.4872 4.94533 83.2691 5.74287 84.2487 5.74287ZM84.2589 5.36078C83.4881 5.36078 82.9244 4.72692 82.9244 3.92938C82.9244 3.14252 83.4881 2.49799 84.2487 2.49799C85.0102 2.49799 85.5628 3.14252 85.5628 3.9405C85.5628 4.72692 85.0102 5.36078 84.2589 5.36078ZM83.5815 4.86882H83.9779V4.14778H84.1655C84.3845 4.14778 84.489 4.23541 84.5195 4.43202C84.5296 4.47172 84.5389 4.50981 84.5477 4.54592C84.5849 4.69872 84.6135 4.81593 84.6553 4.86882H85.0832C85.0408 4.80343 85.0102 4.69401 84.9576 4.4209C84.9058 4.1807 84.8115 4.04948 84.6452 3.9841V3.9623C84.8531 3.89647 84.9992 3.74345 84.9992 3.54685C84.9992 3.37204 84.9261 3.23014 84.8328 3.15364C84.7071 3.07713 84.5611 3.02242 84.2385 3.02242C83.9567 3.02242 83.7377 3.04421 83.5815 3.07713V4.86882ZM84.1757 3.85288H83.9881V3.33957C84.0297 3.32845 84.1027 3.31733 84.2071 3.31733C84.4576 3.31733 84.5722 3.42675 84.5722 3.59088C84.5722 3.77637 84.3947 3.85288 84.1757 3.85288Z"
                                fill="currentColor"
                            ></path>
                        </svg>
                    </h1>
                </header>
                <section class="flex flex-col mb-2">
                    <label for="email" class="mb-1 text-md text-black"
                        >Correo electrónico</label
                    >
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="p-2 text-gray-500 focus:outline-none"
                        v-model="email"
                        required
                    />
                </section>
                <section class="flex flex-col mb-2">
                    <label for="password" class="mb-1 text-md text-black"
                        >Contraseña</label
                    >
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="p-2 text-gray-500 focus:outline-none"
                        v-model="password"
                        required
                    />
                </section>

                <MainButton :button_label="button_label" @auth="onLogin" />
            </form>
            <section class="mt-6 text-center text-sm">
                <span>
                    ¿Aún no tienes una cuenta?
                    <Link href="/register" class="text-blue-400"
                        >Registrarse</Link
                    >
                </span>
            </section>
        </section>
    </article>
</template>

<style></style>
