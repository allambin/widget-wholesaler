<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0">
        <h1 class="text-6xl pt-5 pb-10">
            <Link href="/">
                Wally's Widget Company
            </Link>
        </h1>

        <div class="container mx-auto px-4">
            <slot />
        </div>
    </div>
</template>
