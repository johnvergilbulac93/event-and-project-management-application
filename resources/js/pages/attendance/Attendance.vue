<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import ConfirmAlertDialog from '@/usable/ConfirmAlertDialog.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import debounce from 'lodash.debounce';
import { onMounted, reactive, ref, watch } from 'vue';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manage Attendance',
        href: '/attendance/list',
    },
];

const { flash } = usePage().props as any;
const props = defineProps({ events: Object, filter: Object });
const form = reactive({
    search: props.filter?.search || '',
    page: 1,
    limit: 10,
});

const onCreate = () => {
    router.visit(route('event.create.index'), { method: 'get' });
};
const filter = debounce(() => {
    router.get('/attendance/list', form, {
        preserveState: true,
        replace: true,
    });
}, 200);
const visible = ref(false);

const eventId = ref('');
const onUpdate = (id: string) => {
    router.visit(route('event.update.index', id));
};
const onDelete = (id: string) => {
    visible.value = true;
    eventId.value = id;
};
const confirmDelete = () => {
    router.delete(route('event.destroy', eventId.value), { onSuccess: () => toast.success('Successfully deleted.') });
};
const onScanner = (id: number) => {
    router.visit(route('attendance.scanner.index', id));
};
function formatTime(time: string) {
    if (!time) return '';
    const [hour, minute] = time.split(':');
    const h = parseInt(hour);
    const ampm = h >= 12 ? 'PM' : 'AM';
    const hour12 = h % 12 || 12;
    return `${hour12}:${minute} ${ampm}`;
}
onMounted(() => {
    if (flash.message) {
        toast.success(flash.message);
    }
});

watch(form, (newVal) => {
    form.page = 1;
    filter();
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Toaster richColors position="top-right" />
        <Head title="Manage Attendance" />
        <div class="px-4 py-6">
            <Heading title="Manage Attendance" description="Manage your attendance" />
            <div class="rounded border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Event Name</TableHead>
                            <TableHead>Event Description</TableHead>
                            <TableHead>Start Time</TableHead>
                            <TableHead>End Time</TableHead>
                            <TableHead>Date</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead></TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="events?.data.length">
                            <TableRow v-for="item in events.data" :key="item.id">
                                <TableCell class="font-medium">
                                    {{ item.title }}
                                </TableCell>
                                <TableCell class="font-medium">
                                    {{ item.description }}
                                </TableCell>
                                <TableCell class="font-medium">
                                    {{ formatTime(item.start_time) }}
                                </TableCell>
                                <TableCell class="font-medium">
                                    {{ formatTime(item.end_time) }}
                                </TableCell>
                                <TableCell class="font-medium">
                                    {{ item.date }}
                                </TableCell>
                                <TableCell
                                    ><Badge :class="item.status == 0 ? 'bg-red-500' : ''" v-text="item.status == 1 ? 'Active' : 'Inactive'"
                                /></TableCell>
                                <TableCell class="w-20 text-center">
                                    <Button @click="onScanner(item.id)">Go To QR Scanner</Button>
                                </TableCell>
                            </TableRow>
                        </template>
                        <template v-else>
                            <TableRow>
                                <TableCell colspan="7" class="text-center font-medium"> No record found </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </div>
        </div>
        <ConfirmAlertDialog @continue="confirmDelete" v-model:visible="visible" />
    </AppLayout>
</template>
