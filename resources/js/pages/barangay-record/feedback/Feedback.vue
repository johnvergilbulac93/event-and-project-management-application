<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Head, router } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import Layout from './../Layout.vue';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { MoreHorizontal, Plus } from 'lucide-vue-next';
import moment from 'moment';
import debounce from 'lodash.debounce';
import { toast } from 'vue-sonner';
import ConfirmAlertDialog from '@/usable/ConfirmAlertDialog.vue';

import { reactive, ref, watch } from 'vue';
import Form from './Form.vue';
interface feedbackItem {
    Name: string;
    Email: string;
    Subject: string;
    Comment: string;
}
const selectedFeedBackItem = reactive<feedbackItem>({
    Name: '',
    Email: '',
    Subject: '',
    Comment: '',
});
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Feedback',
        href: '/barangay-record/feedback',
    },
];
const props = defineProps({ feedbacks: Object, filter: Object });
const form = reactive({
    search: props.filter?.search || '',
    page: 1,
    limit: 10,
});
const feedbackId = ref('');
const visible = ref(false);
const visible2 = ref(false);
const filter = debounce(() => {
    router.get(route('feedback.index'), form, {
        preserveState: true,
        replace: true,
    });
}, 200);
const onDelete = (id: number) => {
    visible.value = true;
    feedbackId.value = id.toString();
};
const onView = (item: any) => {
    selectedFeedBackItem.Name = item.name;
    selectedFeedBackItem.Email = item.email;
    selectedFeedBackItem.Subject = item.subject;
    selectedFeedBackItem.Comment = item.comment;
    visible2.value = true;
};
const confirmDelete = () => {
    router.delete(route('feedback.destroy', feedbackId.value), { onSuccess: () => toast.success('Successfully deleted.') });
};
watch(form, (newVal) => {
    form.page = 1;
    filter();
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Toaster richColors position="top-right" />

        <Head title="Feedback" />
        <Layout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Feedback" description="View feedback" />
            </div>
            <div class="mt-4">
                <div class="flex justify-between gap-2">
                    <div class="mb-4 flex gap-2 sm:w-full md:w-1/2">
                        <Input v-model="form.search" id="search" type="text" required autofocus :tabindex="1"
                            autocomplete="search" placeholder="search" />
                        <!-- <Button @click="handleSearch"> <Search />Search </Button> -->
                    </div>
                    <!-- <Button @click="onCreate"> <Plus /> Add </Button> -->
                </div>
                <div class="rounded border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <!-- <TableHead>Name</TableHead>
                                <TableHead>Email</TableHead> -->
                                <TableHead>Subject</TableHead>
                                <TableHead>Comment</TableHead>
                                <TableHead>Date Submitted</TableHead>
                                <TableHead></TableHead>

                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <template v-if="feedbacks.data.length">
                                <TableRow v-for="item in feedbacks.data" :key="item.id">
                                    <!-- <TableCell class="font-medium">
                                        {{ item.name }}
                                    </TableCell>
                                    <TableCell class="font-medium">
                                        {{ item.email }}
                                    </TableCell> -->
                                    <TableCell>
                                        {{ item.subject }}

                                    </TableCell>
                                    <TableCell>
                                        {{ item.comment }}

                                    </TableCell>
                                    <TableCell>
                                        {{ moment(item.created_at).format('LLL') }}

                                    </TableCell>
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
                                                <DropdownMenuItem class="cursor-pointer" @click="onView(item)">
                                                    View </DropdownMenuItem>
                                                <DropdownMenuItem class="cursor-pointer" @click="onDelete(item.id)">
                                                    Delete </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </TableCell>
                                </TableRow>
                            </template>
                            <template v-else>
                                <TableRow>
                                    <TableCell colspan="4" class="text-center font-medium"> No record found </TableCell>
                                </TableRow>
                            </template>
                        </TableBody>
                    </Table>
                </div>
                <div class="mt-4 flex items-center justify-between gap-1">
                    <div class="flex gap-1">
                        <Button v-for="link in feedbacks?.links" :key="link.label"
                            :variant="link.active ? 'default' : 'outline'" :disabled="!link.url" v-html="link.label"
                            @click="link.url && router.visit(link.url)" />
                    </div>
                    <div>
                        Showing {{ feedbacks?.from ? feedbacks?.from : 0 }} to {{ feedbacks?.to ? feedbacks?.to : 0 }}
                        of
                        {{ feedbacks?.total ? feedbacks?.total : 0 }} entries
                    </div>
                </div>
            </div>
        </Layout>
        <ConfirmAlertDialog @continue="confirmDelete" v-model:visible="visible" />
        <Form v-model:open="visible2" :item="selectedFeedBackItem" />
    </AppLayout>
</template>
