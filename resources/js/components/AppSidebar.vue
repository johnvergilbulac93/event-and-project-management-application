<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Archive, BookOpen, Calendar, Folder, FolderDot, FolderSearch, LayoutGrid, ListCheck, MessageSquareMore, User } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard/',
        icon: LayoutGrid,
    },
    {
        title: 'Profile Account',
        href: '/user/list',
        icon: User,
    },
    {
        title: 'Barangay Record',
        href: '/barangay-record/list',
        icon: Archive,
    },
    {
        title: 'Event',
        href: '/event/list',
        icon: Calendar,
    },
    {
        title: 'Attendance',
        href: '/attendance/list',
        icon: ListCheck,
    },
    {
        title: 'Project',
        href: '/projects/list',
        icon: FolderDot,
    },
    {
        title: 'Feedback',
        href: '/feedback/list',
        icon: MessageSquareMore,
    },
    {
        title: 'Report',
        href: '/report',
        icon: FolderSearch,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                        <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <!-- <NavFooter :items="footerNavItems" /> -->
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
