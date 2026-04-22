<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import Layout from './../Layout.vue';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import { router, usePage } from '@inertiajs/vue3';
import { toPng } from 'html-to-image';
import debounce from 'lodash.debounce';
import { MoreHorizontal, Plus } from 'lucide-vue-next';
import { onMounted, reactive, ref, watch } from 'vue';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Household Head Profile',
        href: '/barangay-record/profile-account',
    },
];

const { flash } = usePage().props as any;
const props = defineProps({ users: Object, filter: Object });
const form = reactive({
    search: props.filter?.search || '',
    page: 1,
    limit: 10,
});

const onCreate = () => {
    router.visit(route('barangay-record.profile-account.create'), { method: 'get' });
};
const filter = debounce(() => {
    router.get('/barangay-record/profile-account', form, {
        preserveState: true,
        replace: true,
    });
}, 200);
const templateReference = ref(null);
const visible = ref(false);
const visible2 = ref(false);
const downloading = ref(false);
const userId = ref();
const qrValue = ref('');
const moduleType = ref('Household');
const onUpdate = (id: number) => {
    router.visit(route('barangay-record.profile-account.update.index', id));
};
const onDelete = (id: number) => {
    visible.value = true;
    userId.value = id;
};
const confirmDelete = () => {
    router.delete(route('barangay-record.profile-account.destroy', userId.value), { onSuccess: () => toast.success('Successfully deleted.') });
};
const showQrCode = (record: any) => {
    qrValue.value = record.email;
    visible2.value = true;
};
const downloadQRCode = () => {
    if (templateReference.value === null) {
        return;
    }

    downloading.value = true;

    toPng(templateReference.value)
        .then((dataUrl) => {
            const link = document.createElement('a');
            link.download = 'my-qrcode.png';
            link.href = dataUrl;
            link.click();
            downloading.value = false;
        })
        .catch((err) => {
            console.log(err, templateReference.value);
            downloading.value = false;
        });
};
const onHouseHold = (id: number) => {
    router.visit(route('household.index', id));
};
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

        <Head title="Profile Account" />
        <Layout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Profile Account" description="Manage profile account" />
            </div>
            <Toaster richColors closeButton position="top-right" />
            <div class="mt-4">
                <div class="flex justify-between gap-2">
                    <div class="mb-4 flex gap-2 sm:w-full md:w-1/2">
                        <Input v-model="form.search" id="search" type="text" required autofocus :tabindex="1"
                            autocomplete="search" placeholder="search" />
                        <!-- <Button @click="handleSearch"> <Search />Search </Button> -->
                    </div>
                    <Button @click="onCreate">
                        <Plus /> Add
                    </Button>
                </div>
                <div class="rounded border">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Gender</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead></TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <template v-if="users.data.length">
                                <TableRow v-for="item in users.data" :key="item.id">
                                    <TableCell class="font-medium">
                                        {{ item.full_name }}
                                    </TableCell>
                                    <TableCell class="font-medium">
                                        {{ item.gender }}
                                    </TableCell>
                                    <TableCell>
                                        <Badge :class="item.isActive == 0 ? 'bg-red-500' : ''"
                                            v-text="item.isActive == 1 ? 'Active' : 'Inactive'" />
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
                                                <DropdownMenuItem class="cursor-pointer" @click="onUpdate(item.id)">
                                                    View </DropdownMenuItem>
                                                <DropdownMenuItem class="cursor-pointer" @click="onDelete(item.id)">
                                                    Delete </DropdownMenuItem>
                                                <DropdownMenuItem class="cursor-pointer" @click="onHouseHold(item.id)">
                                                    Household Member
                                                </DropdownMenuItem>
                                                <DropdownMenuItem class="cursor-pointer" @click="showQrCode(item)"> Show
                                                    Qr Code </DropdownMenuItem>
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
                        <Button v-for="link in users?.links" :key="link.label"
                            :variant="link.active ? 'default' : 'outline'" :disabled="!link.url" v-html="link.label"
                            @click="link.url && router.visit(link.url)" />
                    </div>
                    <div>
                        Showing {{ users?.from ? users?.from : 0 }} to {{ users?.to ? users?.to : 0 }} of
                        {{ users?.total ? users?.total : 0 }} entries
                    </div>
                </div>
            </div>
            <ConfirmAlertDialog @continue="confirmDelete" v-model:visible="visible" />
            <Dialog @ok="downloadQRCode" :button-text="'Download'" v-model:visible2="visible2"
                :title="'Download your Qr Code'">
                <div class="flex items-center justify-center" ref="templateReference">
                    <vue-qrcode :value="qrValue" :options="{
                        width: 460,
                        color: { dark: '#031002', light: '#ffffff' },
                    }" />
                </div>
            </Dialog>
        </Layout>
    </AppLayout>
</template>
