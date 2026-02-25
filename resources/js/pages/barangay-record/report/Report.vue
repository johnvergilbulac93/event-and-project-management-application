<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import Layout from './../Layout.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Report',
        href: '/barangay-record/report',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Report" />
        <Layout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Report" description="Generate report" />
            </div>
        </Layout>
    </AppLayout>
</template>
