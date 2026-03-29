<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

interface ProjectItem {
    name: string;
    location: string;
    cost: string;
    start_date: string;
    completion_date: string;
    status: string;
    url: string;
}
import dayjs from 'dayjs';
import moment from 'moment';
const open = defineModel<boolean>('isOpen');
const props = defineProps<{
    item: ProjectItem;
}>();
const formatPeso = (value: any) => {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 0,
    }).format(value);
};
const formatTime = (time: string) => {
    return new Date(`1970-01-01T${time}`)
        .toLocaleTimeString([], { hour: 'numeric', minute: '2-digit', hour12: true });
};
</script>

<template>
    <Dialog v-model:open="open" class="p-6">

        <DialogContent class="">
            <DialogHeader>
                <DialogTitle class="capitalize">{{ item.name }}</DialogTitle>
                <div class="">
                    <img class="w-full h-40 object-cover rounded " :src="item.url || '/images/logo.png'"
                        alt="image">
                    <Table class="border mt-4 rounded">
                        <TableBody>
                            <TableRow class="font-bold">
                                <TableHead class="w-44">Location</TableHead>
                                <TableHead class="uppercase">{{ item.location }}</TableHead>
                            </TableRow>
                            <TableRow class="font-bold">
                                <TableHead>Cost</TableHead>
                                <TableHead>{{ formatPeso(item.cost) }}</TableHead>
                            </TableRow>
                            <TableRow class="font-bold ">
                                <TableHead>Start Date</TableHead>
                                <TableHead>{{ moment(item.start_date).format('LL') }}</TableHead>
                            </TableRow>
                            <TableRow class="font-bold">
                                <TableHead>Completion Date</TableHead>
                                <TableHead>{{ moment(item.completion_date).format('LL') }}</TableHead>
                            </TableRow>
                            <TableRow class="font-bold">
                                <TableHead>Status</TableHead>
                                <TableHead>
                                    <span
                                        class="inline-flex items-center bg-gray-50  border text-xs font-medium px-1.5 py-0.5 rounded-sm">

                                        {{ item.status }}
                                    </span>
                                </TableHead>
                            </TableRow>

                            <!-- <TableCell class="font-medium">
                                {{ item.name }}
                            </TableCell>
                            <TableCell class="font-medium">
                                {{ item.location }}
                            </TableCell>
                            <TableCell class="font-medium">
                                {{ item.cost }}
                            </TableCell>
                            <TableCell class="font-medium">
                                {{ item.start_date }}
                            </TableCell>
                            <TableCell class="font-medium">
                                {{ item.completion_date }}
                            </TableCell>
                            <TableCell class="font-medium">
                                {{ item.status }}
                            </TableCell> -->
                        </TableBody>
                    </Table>
                </div>
            </DialogHeader>
            <DialogFooter>
                <DialogClose as-child>
                    <Button variant="outline">
                        Close
                    </Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>

    </Dialog>
</template>
