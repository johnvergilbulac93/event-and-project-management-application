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
const events = ref([])
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
    axios.get('/barangay-record/report/event')
        .then((response) => {
            events.value = response.data.data;
            loading.value = false;
        }).catch((error) => {
            loading.value = false;
            emit('tab', 'event');
        }).finally(() => {
            loading.value = false;
            emit('tab', 'event');
        });
}
const exportToExcel = () => {
    exceLoading.value = true;
    axios.get('/barangay-record/report/event/export', { responseType: 'blob' })
        .then((response) => {
            console.log(response.data);
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `event_${moment().format('YYYYMMDD_HHmmss')}.xlsx`);
            document.body.appendChild(link);
            link.click();
            link.remove();
        }).catch((error) => {
            exceLoading.value = false;
            emit('tab', 'event');
        }).finally(() => {
            exceLoading.value = false;
            emit('tab', 'event');

        });
}

function formatTime(time: string) {
    if (!time) return '';
    const [hour, minute] = time.split(':');
    const h = parseInt(hour);
    const ampm = h >= 12 ? 'PM' : 'AM';
    const hour12 = h % 12 || 12;
    return `${hour12}:${minute} ${ampm}`;
}
</script>

<template>
    <div class="flex justify-end items-center gap-3 mt-2">
        <!-- <Button @click="generateProfileAccount" class="cursor-pointer">
            <FolderOpen v-if="!loading" />
            <Spinner v-else />
            <span>Generate Feedbacks</span>
        </Button> -->
        <Button @click="exportToExcel" v-if="events.length" class="cursor-pointer">
            <Grid3X3 v-if="!exceLoading" />
            <Spinner v-else />
            <span>Export To Excel</span>
        </Button>

    </div>
    <div class="border rounded mt-4">
        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead>Title</TableHead>
                    <TableHead>Description</TableHead>
                    <TableHead>Start Time</TableHead>
                    <TableHead>End Time</TableHead>
                    <TableHead>Date</TableHead>
                    <TableHead>Status</TableHead>

                </TableRow>
            </TableHeader>
            <TableBody>
                <template v-if="events.length">
                    <TableRow v-for="item in events" :key="item.id">
                        <TableCell class="font-medium">
                            {{ item.title }}
                        </TableCell>
                        <TableCell class="font-medium ">
                            {{ item.description }}
                        </TableCell>
                        <TableCell class="font-medium">
                            {{ formatTime(item.start_time) }}
                        </TableCell>
                        <TableCell class="font-medium">
                            {{ formatTime(item.end_time) }}
                        </TableCell>
                        <TableCell class="font-medium">
                            {{ moment(item.date).format('LL') }}
                        </TableCell>
                        <TableCell>
                            <Badge :class="item.status == 0 ? 'bg-red-500' : ''"
                                v-text="item.status == 1 ? 'Active' : 'Inactive'" />
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
