<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import axios from 'axios';
import debounce from 'lodash.debounce';
import moment from 'moment';
import { nextTick, onMounted, reactive, ref, watch } from 'vue';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manage Attendance',
        href: '/attendance/create',
    },
];
const props = defineProps({ event: Object });

const form = reactive({
    id: '',
    name: '',
    result: '',
});
const inputRef = ref<HTMLInputElement | null>(null);

const result = ref('');
const attendees = ref({});
const filter = reactive({
    search: '',
    page: 1,
});


const getUser = async (email: string) => {
    try {
        const { data, status } = await axios.post(`/attendance`, { email: email, event_id: props.event?.id });
        form.name = data.user.full_name;
        toast.success(data.message);
    } catch (error) {
        toast.error(error?.response.data.message);
    }
};

const getAttendees = debounce(async () => {
    const { data } = await axios.get(`/attendance/attendees/${props.event?.id}`, { params: filter });
    attendees.value = data;
}, 200);

const onChange = debounce(() => {
    getUser(form.result);
    getAttendees();
    form.result = '';
}, 200);
const focusInput = () => {
    nextTick(() => {
        inputRef.value?.focus();
    });
};
watch(filter, (newVal) => {
    filter.page = 1;
    getAttendees();
});
onMounted(() => {
    getAttendees();
    focusInput();
    document.addEventListener('click', (e) => {
        const target = e.target as HTMLElement;
        if (!target.closest('.search-input')) {
            focusInput();
        }
    });
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="QR Scanner Attendance" />
        <Toaster richColors position="top-right" />
        <div class="px-4 py-6">
            <Heading title="Attendance Scanner" description="Scan user qr code" />
            <h2 class="text-xl font-bold">{{ event?.title }}</h2>
            <div class="w-full">
                <input ref="inputRef" type="password" @keyup="onChange" v-model="form.result"
                    placeholder="Put the cursor here and scan the qr code" class="absolute -left-[9999px]" />
                <p class="mt-4 text-sm font-bold">Previous Scan Attendee: &nbsp;{{ form.name }}</p>
            </div>
            <Input class="search-input my-4 sm:w-full lg:w-1/2" type="text" v-model="filter.search"
                placeholder="enter name to search" />
            <div class="mt-4 rounded border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>Time</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="attendees.data?.length">
                            <TableRow v-for="item in attendees.data as any" :key="item.id">
                                <TableCell class="font-medium">
                                    {{ item?.household?.full_name }}
                                </TableCell>
                                <TableCell class="font-medium">
                                    <!-- {{ formatTime(item.created_at) }} -->
                                    {{ moment(item.created_at).format('LTS') }}
                                </TableCell>
                            </TableRow>
                        </template>
                        <template v-else>
                            <TableRow>
                                <TableCell colspan="2" class="text-center font-medium"> No record found </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </div>
            <div class="mt-4 flex items-center justify-between gap-1">
                <div class="flex gap-1">
                    <Button v-for="link in attendees?.links" :key="link.label"
                        :variant="link.active ? 'default' : 'outline'" :disabled="!link.url" v-html="link.label"
                        @click="link.url && router.visit(link.url)" />
                </div>
                <div>
                    Showing {{ attendees?.from ? attendees?.from : 0 }} to {{ attendees?.to ? attendees?.to : 0 }} of
                    {{ attendees?.total ? attendees?.total : 0 }} entries
                </div>
            </div>
        </div>
    </AppLayout>
</template>
