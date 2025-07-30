<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import Heading from '@/components/Heading.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Generate Report',
        href: '/report',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Generate Report" />
        <div class="px-4 py-6">
            <Heading title="Report" description="Generate your report" />
        </div>
    </AppLayout>
</template>
