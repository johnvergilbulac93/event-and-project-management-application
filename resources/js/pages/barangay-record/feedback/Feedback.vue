<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import Layout from './../Layout.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Feedback',
        href: '/barangay-record/feedback',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Feedback" />
        <Layout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Feedback" description="View feedback" />
            </div>
        </Layout>
    </AppLayout>
</template>
