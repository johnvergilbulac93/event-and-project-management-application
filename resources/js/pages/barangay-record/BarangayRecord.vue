<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import Heading from '@/components/Heading.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manage Barangay Record',
        href: '/barangay-record/list',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Manage Barangay Record" />
        <div class="px-4 py-6">
            <Heading title="Barangay Record" description="Manage your barangay record" />
        </div>
    </AppLayout>
</template>
