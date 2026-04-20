<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Household Head Profile',
        href: '/barangay-record/profile-account',
        roles: ['admin', 'guest'],
    },
    {
        title: 'Attendance',
        href: '/barangay-record/attendance',
        roles: ['admin', 'guest'],

    },
    {
        title: 'Feedback',
        href: '/barangay-record/feedback',
        roles: ['admin', 'guest'],

    },
    {
        title: 'Report',
        href: '/barangay-record/report',
        roles: ['admin', 'guest'],

    },
    {
        title: 'Archives',
        href: '/barangay-record/archives',
        roles: ['admin'],
    },
    // {
    //     title: 'Appearance',
    //     href: '/settings/appearance',
    // },
];

const page = usePage();
const roleType = page.props.auth?.user?.role;


const filteredNavItems = sidebarNavItems.filter(item => {
    return !item.roles || item.roles.includes(roleType);
});

const currentPath = page.props.ziggy?.location ? new URL(page.props.ziggy.location).pathname : '';
</script>

<template>
    <div class="px-4 py-6">
        <Heading title="Barangay Record" description="Manage your barangay record" />

        <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-y-0 lg:space-x-12">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-y-1 space-x-0">
                    <Button v-for="item in filteredNavItems" :key="item.href" variant="ghost"
                        :class="['w-full justify-start', { 'bg-muted': currentPath === item.href }]" as-child>
                        <Link :href="item.href">
                            {{ item.title }}
                        </Link>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 md:hidden" />

            <div class="flex-1">
                <section>
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
