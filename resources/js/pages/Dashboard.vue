<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

defineProps({ hHead: Number, hMember: Number, event: Number, project: Number });
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <Link href="/user/list" class="rounded-xl border bg-card text-card-foreground shadow">
                    <div class="flex flex-row items-center justify-between space-y-0 gap-y-1.5 p-6 pb-2">
                        <h3 class="text-md font-normal tracking-tight">HouseHold</h3>
                    </div>
                    <div class="flex">
                        <div class="p-6 pt-0">
                           <h3 class="text-sm text-muted-foreground font-normal tracking-tight">Head</h3>
                            <div class="text-2xl font-bold">{{ hHead }}</div>
                        </div>
                        <div class="p-6 pt-0">
                             <h3 class="text-sm text-muted-foreground font-normal tracking-tight">Member</h3>
                            <div class="text-2xl font-bold">{{ hMember }}</div>
                        </div>
                    </div>
                </Link>
                
                <Link href="/event/list" class="rounded-xl border bg-card text-card-foreground shadow">
                    <div class="flex flex-row items-center justify-between space-y-0 gap-y-1.5 p-6 pb-2">
                        <h3 class="text-sm font-normal tracking-tight">Events</h3>
                    </div>
                    <div class="p-6 pt-0">
                        <div class="text-3xl font-bold">{{ event }}</div>
                    </div>
                </Link>
                <Link href="/projects/list" class="rounded-xl border bg-card text-card-foreground shadow">
                    <div class="flex flex-row items-center justify-between space-y-0 gap-y-1.5 p-6 pb-2">
                        <h3 class="text-sm font-normal tracking-tight">Projects</h3>
                    </div>
                    <div class="p-6 pt-0">
                        <div class="text-3xl font-bold">{{ project }}</div>
                    </div>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
