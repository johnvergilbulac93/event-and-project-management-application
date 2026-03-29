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
const selectedEvent = ref('');
const emit = defineEmits(['tab']);
const attendances = ref([])
import axios from 'axios';
import moment from 'moment';
import ComboBox from '@/usable/ComboBox.vue';
import { toast } from 'vue-sonner';
defineProps({ events: Array });
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Report',
        href: '/barangay-record/report',
    },
];

const generate = () => {
    if (!selectedEvent.value) {
        toast.error('Please select an event first.');
        emit('tab', 'attendance');
        return;
    }

    loading.value = true;
    axios.get(`/barangay-record/report/attendance/${selectedEvent.value}`)
        .then((response) => {
            attendances.value = response.data.data;
            loading.value = false;
        }).catch((error) => {
            loading.value = false;
            emit('tab', 'attendance');
        }).finally(() => {
            loading.value = false;
            emit('tab', 'attendance');
        });
}
const exportToExcel = () => {
    exceLoading.value = true;
    axios.get(`/barangay-record/report/attendance/${selectedEvent.value}/export`, { responseType: 'blob' })
        .then((response) => {
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `attendance_${moment().format('YYYYMMDD_HHmmss')}.xlsx`);
            document.body.appendChild(link);
            link.click();
            link.remove();
        }).catch((error) => {
            exceLoading.value = false;
            emit('tab', 'attendance');
        }).finally(() => {
            exceLoading.value = false;
            emit('tab', 'attendance');

        });
}


</script>

<template>

    <div class="flex justify-between items-center gap-3 mt-2">

        <div class="flex items-center gap-2">
            <ComboBox v-model="selectedEvent" :options="events" />
            <Button @click="generate" class="cursor-pointer">
                <FolderOpen v-if="!loading" />
                <Spinner v-else />
                <span>Generate Attendance</span>
            </Button>
        </div>
        <Button @click="exportToExcel" v-if="attendances.length" class="cursor-pointer">
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
                    <TableHead>Event </TableHead>
                    <TableHead>Date of Event </TableHead>

                </TableRow>
            </TableHeader>
            <TableBody>
                <template v-if="attendances.length">
                    <TableRow v-for="item in attendances" :key="item.id">
                        <TableCell class="font-medium">
                            {{ item?.household.full_name }}
                        </TableCell>
                        <TableCell class="font-medium">
                            {{ item?.event.title }}
                        </TableCell>
                        <TableCell class="font-medium">
                            {{ moment(item.event.date).format('LL') }}
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
