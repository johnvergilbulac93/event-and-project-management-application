<script setup lang="ts">
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';
import Layout from '@/pages/barangay-record/Layout.vue';
import { Head } from '@inertiajs/vue3';
import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from '@/components/ui/tabs'
import HeadingSmall from '@/components/HeadingSmall.vue';
import { ref } from 'vue';
import ProfileAccount from './tabs/ProfileAccount.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manage Archives',
        href: '/barangay-record/archives',
    },
];

const defaultTab = ref('profile-account');

const props = defineProps({ users: Object, filter: Object });

</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Archives" />
        <Layout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Archives" description="Manage archives" />
            </div>
            <Toaster richColors closeButton position="top-right" />
            <div class="flex w-full flex-col gap-6 mt-4">
                <Tabs v-model="defaultTab">
                    <TabsList>
                        <TabsTrigger value="profile-account" class="cursor-pointer">
                            Profile Account
                        </TabsTrigger>
                    </TabsList>
                    <TabsContent value="profile-account" class="w-full">
                        <ProfileAccount :users="users" />
                    </TabsContent>
                </Tabs>
            </div>
        </Layout>
    </AppLayout>
</template>
