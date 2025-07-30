<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import ConfirmAlertDialog from '@/usable/ConfirmAlertDialog.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import debounce from 'lodash.debounce';
import { MoreHorizontal } from 'lucide-vue-next';
import { onMounted, reactive, ref, watch } from 'vue';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manage Event',
        href: '/event/list',
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
    router.get('/event/list', form, {
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
        <Head title="Manage Event" />
        <div class="px-4 py-6">
            <Heading title="Manage Event" description="Manage your event" />
            <div class="flex justify-between gap-2">
                <div class="mb-4 flex gap-2 sm:w-full md:w-1/2">
                    <Input
                        v-model="form.search"
                        id="search"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="search"
                        placeholder="search"
                    />
                    <!-- <Button @click="handleSearch"> <Search />Search </Button> -->
                </div>
                <Button @click="onCreate"> <Plus /> Create Event </Button>
            </div>
            <div class="rounded border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Title</TableHead>
                            <TableHead>Description</TableHead>
                            <TableHead>Start Time</TableHead>
                            <TableHead>End Time</TableHead>
                            <TableHead>Date</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead></TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="events.data.length">
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
                                    <DropdownMenu>
                                        <DropdownMenuTrigger as-child>
                                            <Button variant="ghost" class="h-8 w-8 p-0">
                                                <span class="sr-only">Open menu</span>
                                                <MoreHorizontal class="h-4 w-4" />
                                            </Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="end">
                                            <DropdownMenuLabel>Actions</DropdownMenuLabel>
                                            <DropdownMenuItem class="cursor-pointer" @click="onUpdate(item.id)"> View </DropdownMenuItem>
                                            <DropdownMenuItem class="cursor-pointer" @click="onDelete(item.id)"> Delete </DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
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
            <div class="mt-4 flex items-center justify-between gap-1">
                <div class="flex gap-1">
                    <Button
                        v-for="link in events?.links"
                        :key="link.label"
                        :variant="link.active ? 'default' : 'outline'"
                        :disabled="!link.url"
                        v-html="link.label"
                        @click="link.url && router.visit(link.url)"
                    />
                </div>
                <div>
                    Showing {{ events?.from ? events?.from : 0 }} to {{ events?.to ? events?.to : 0 }} of
                    {{ events?.total ? events?.total : 0 }} entries
                </div>
            </div>
        </div>
        <ConfirmAlertDialog @continue="confirmDelete" v-model:visible="visible" />
    </AppLayout>
</template>
