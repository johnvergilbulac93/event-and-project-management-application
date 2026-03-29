<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { type BreadcrumbItem } from '@/types';
import Drawer from '@/usable/Drawer.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { MoreHorizontal, Plus } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast } from 'vue-sonner';

const props = defineProps({ househead_id: Number, household: Object });
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manage Household Member',
        href: '/household',
    },
];
const form = useForm({
    household_head_id: props.househead_id,
    id: '',
    name: '',
    gender: '',
});
const isOpen = ref(false);
const isAdd = ref(false);
const visible = ref(false);

const onCreate = () => {
    form.reset('name', 'gender');
    isAdd.value = true;
    isOpen.value = true;
};
const onSave = () => {
    form.post(route('household.store'), {
        onSuccess: () => {
            toast.success('Successfully saved.');
            isOpen.value = false;
        },
    });
};
const showUpdateDialog = (record: any) => {
    form.name = record.name;
    form.gender = record.gender;
    form.id = record.id;
    isAdd.value = false;
    isOpen.value = true;
};
const showDeleteDialog = (id: any) => {
    form.id = id;
    visible.value = true;
};
const onUpdate = () => {
    form.put(route('household.update', form.id), {
        onSuccess: () => {
            toast.success('Successfully updated.');
            isOpen.value = false;
        },
    });
};
const onDelete = () => {
    router.delete(route('household.destroy', form.id), { onSuccess: () => toast.success('Successfully deleted.') });
};
</script>
<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Manage Household Member" />
        <Toaster richColors closeButton position="top-right" />
        <div class="px-4 py-6">
            <Heading title="Household Member" description="Manage the household member" />
            <div class="mb-2 flex items-center justify-end">
                <Button @click="onCreate"> <Plus /> Add </Button>
            </div>
            <div class="rounded border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>Gender</TableHead>
                            <TableHead></TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="household.length">
                            <TableRow v-for="item in household" :key="item.id">
                                <TableCell class="font-medium">
                                    {{ item.name }}
                                </TableCell>
                                <TableCell class="font-medium">
                                    {{ item.gender }}
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
                                            <DropdownMenuItem class="cursor-pointer" @click="showUpdateDialog(item)"> View </DropdownMenuItem>
                                            <DropdownMenuItem class="cursor-pointer" @click="showDeleteDialog(item.id)"> Delete </DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </TableCell>
                            </TableRow>
                        </template>
                        <template v-else>
                            <TableRow>
                                <TableCell colspan="3" class="text-center font-medium"> No record found </TableCell>
                            </TableRow>
                        </template>
                    </TableBody>
                </Table>
            </div>
        </div>
        <ConfirmAlertDialog @continue="onDelete" v-model:visible="visible" />

        <Drawer :title="'Add Household Member'" :description="'Manage household member of the family'" v-model:isOpen="isOpen">
            <form @submit.prevent="isAdd ? onSave() : onUpdate()" class="grid items-start gap-4 px-4">
                <div class="grid gap-2">
                    <Label html-for="name">Name</Label>
                    <Input :tabindex="1" id="name" type="text" v-model="form.name" />
                </div>
                <div class="grid gap-2">
                    <Label html-for="gender">Gender</Label>
                    <Select :tabindex="2" v-model="form.gender">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a gender" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Gender</SelectLabel>
                                <SelectItem value="Male"> Male </SelectItem>
                                <SelectItem value="Female"> Female </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <Button type="submit"> Save Changes </Button>
            </form>
        </Drawer>
    </AppLayout>
</template>
<style scoped></style>
