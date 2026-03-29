<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import Layout from './../Layout.vue';
import ProfileAccount from './Profile-Account.vue';
import Feedback from './Feedback.vue';
import Event from './Event.vue';
import Project from './Project.vue';
import Attendance from './Attendance.vue';
import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from '@/components/ui/tabs'
import { ref } from 'vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Report',
        href: '/barangay-record/report',
    },
];
const props = defineProps({ events: Array });

const defaultTab = ref('profile-account');
const onChangeTab = (value: string) => {
    defaultTab.value = value;
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Toaster richColors  position="top-center" />

        <Head title="Report" />
        <Layout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Report" description="Generate report" />
            </div>
            <div class="flex w-full flex-col gap-6 mt-4">
                <Tabs v-model="defaultTab" class="w-full ">
                    <TabsList class=" w-full">
                        <TabsTrigger value="profile-account" class="cursor-pointer">
                            Profile Account
                        </TabsTrigger>
                        <TabsTrigger value="feedback" class="cursor-pointer">
                            Feedback
                        </TabsTrigger>
                        <TabsTrigger value="event" class="cursor-pointer">
                            Event
                        </TabsTrigger>
                        <TabsTrigger value="attendance" class="cursor-pointer">
                            Attendance
                        </TabsTrigger>
                        <TabsTrigger value="project" class="cursor-pointer">
                            Project
                        </TabsTrigger>
                    </TabsList>
                    <TabsContent value="profile-account">
                        <ProfileAccount @tab="onChangeTab" />
                    </TabsContent>
                    <TabsContent value="feedback">
                        <Feedback @tab="onChangeTab" />
                    </TabsContent>
                    <TabsContent value="event">
                        <Event @tab="onChangeTab" />
                    </TabsContent>
                    <TabsContent value="attendance">
                        <Attendance :events="events" @tab="onChangeTab" />
                    </TabsContent>
                    <TabsContent value="project">
                        <Project @tab="onChangeTab" />
                    </TabsContent>
                </Tabs>
            </div>
        </Layout>
    </AppLayout>
</template>
