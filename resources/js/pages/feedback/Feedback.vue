<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import Heading from '@/components/Heading.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manage Feedback',
        href: '/feedback/list',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Manage Feedback" />
        <div class="px-4 py-6">
            <Heading title="Feedback" description="Manage your feedback" />
        </div>
    </AppLayout>
</template>
