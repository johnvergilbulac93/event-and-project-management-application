<script setup lang="ts">
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';

import { Spinner } from '@/components/ui/spinner';
import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from '@/components/ui/tabs'
import { FolderOpen, Grid3X3 } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

const loading = ref(false);
const exceLoading = ref(false);
const emit = defineEmits(['tab']);
const users = ref([])
import axios from 'axios';
import moment from 'moment';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Report',
        href: '/barangay-record/report',
    },
];

onMounted(() => {
    generate();
})

const generate = () => {
    loading.value = true;
    axios.get('/barangay-record/report/profile-account')
        .then((response) => {
            users.value = response.data.data;
            loading.value = false;
        }).catch((error) => {
            loading.value = false;
            emit('tab', 'profile-account');
        }).finally(() => {
            loading.value = false;
            emit('tab', 'profile-account');
        });
}
const exportToExcel = () => {
    exceLoading.value = true;
    axios.get('/barangay-record/report/profile-account/export', { responseType: 'blob' })
        .then((response) => {
            console.log(response.data);
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `profile_account_${moment().format('YYYYMMDD_HHmmss')}.xlsx`);
            document.body.appendChild(link);
            link.click();
            link.remove();
        }).catch((error) => {
            exceLoading.value = false;
            emit('tab', 'profile-account');
        }).finally(() => {
            exceLoading.value = false;
            emit('tab', 'profile-account');

        });
}
</script>

<template>
    <div class="flex justify-end items-center gap-3 mt-2">
        <!-- <Button @click="generateProfileAccount" class="cursor-pointer">
            <FolderOpen v-if="!loading" />
            <Spinner v-else />
            <span>Generate Profile Account</span>
        </Button> -->
        <Button @click="exportToExcel" v-if="users.length" class="cursor-pointer">
            <Grid3X3 v-if="!exceLoading" />
            <Spinner v-else />
            <span>Export To Excel</span>
        </Button>

    </div>
    <div class="border rounded mt-4">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>Name</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead>Date Registered</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <template v-if="users.length">
                    <TableRow v-for="item in users" :key="item.id">
                        <TableCell class="font-medium">
                            {{ item.full_name }}
                        </TableCell>
                        <TableCell>
                            <Badge :class="item.isActive == 0 ? 'bg-red-500' : ''"
                                v-text="item.isActive == 1 ? 'Active' : 'Inactive'" />
                        </TableCell>
                        <TableCell class="font-medium">
                            {{ moment(item.created_at).format('LLL') }}
                        </TableCell>
                    </TableRow>
                </template>
                <template v-else>
                    <TableRow>
                        <TableCell colspan="3" class="text-center font-medium"> No result found </TableCell>
                    </TableRow>
                </template>
            </TableBody>
        </Table>
    </div>

</template>
