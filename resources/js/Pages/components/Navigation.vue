<script setup>
import { Link } from '@inertiajs/inertia-vue3'

</script>

<template>
    <header class="absolute top-0 w-full bg-black text-white">
        <nav
            class="container py-5 px-4 m-auto flex flex-col gap-4 items-center sm:flex-row"
        >
            <div class="flex items-center gap-x-4">
                <h1 class="text-lg">Taxo</h1>
            </div>
            <ul class="flex flex-1 justify-end gap-x-10">
                <Link href="/">
                    Inicio
                </Link>
                <Link href="/login">
                    Login
                </Link>
            </ul>
        </nav>
    </header>
</template>
