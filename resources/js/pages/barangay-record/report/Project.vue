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
const projects = ref([])
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
    axios.get('/barangay-record/report/project')
        .then((response) => {
            projects.value = response.data.data;
            loading.value = false;
        }).catch((error) => {
            loading.value = false;
            emit('tab', 'project');
        }).finally(() => {
            loading.value = false;
            emit('tab', 'project');
        });
}
const exportToExcel = () => {
    exceLoading.value = true;
    axios.get('/barangay-record/report/project/export', { responseType: 'blob' })
        .then((response) => {
            console.log(response.data);
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `project_${moment().format('YYYYMMDD_HHmmss')}.xlsx`);
            document.body.appendChild(link);
            link.click();
            link.remove();
        }).catch((error) => {
            exceLoading.value = false;
            emit('tab', 'project');
        }).finally(() => {
            exceLoading.value = false;
            emit('tab', 'project');

        });
}
const formatPeso = (value: any) => {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 0,
    }).format(value);
};
</script>

<template>
    <div class="flex justify-end items-center gap-3 mt-2">
        <!-- <Button @click="generateProfileAccount" class="cursor-pointer">
            <FolderOpen v-if="!loading" />
            <Spinner v-else />
            <span>Generate Profile Account</span>
        </Button> -->
        <Button @click="exportToExcel" v-if="projects.length" class="cursor-pointer">
            <Grid3X3 v-if="!exceLoading" />
            <Spinner v-else />
            <span>Export To Excel</span>
        </Button>

    </div>
    <div class="border rounded mt-4">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>Project Name</TableHead>
                    <TableHead>Location</TableHead>
                    <TableHead>Cost</TableHead>
                    <TableHead>Start Date</TableHead>
                    <TableHead>Completion Date</TableHead>
                    <TableHead>Status</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <template v-if="projects.length">
                    <TableRow v-for="item in projects" :key="item">
                        <TableCell class="font-medium">
                            {{ item.project_name }}
                        </TableCell>
                        <TableCell class="font-medium">
                            {{ item.location }}
                        </TableCell>
                        <TableCell class="font-medium">
                            {{ formatPeso(item.cost) }}
                        </TableCell>
                        <TableCell class="font-medium">
                            {{ moment(item.start_date).format('LL') }}
                        </TableCell>
                        <TableCell class="font-medium">
                            {{ moment(item.completion_date).format('LL') }}
                        </TableCell>
                        <TableCell class="font-medium">
                            {{ item.status }}
                        </TableCell>
                    </TableRow>
                </template>
                <template v-else>
                    <TableRow>
                        <TableCell colspan="6" class="text-center font-medium"> No result found </TableCell>
                    </TableRow>
                </template>
            </TableBody>
        </Table>
    </div>

</template>
