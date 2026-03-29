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

interface EventItem {
    title: string;
    description: string;
    timeStart: string;
    timeEnd: string;
    date: string;

}
import dayjs from 'dayjs';
import moment from 'moment';
const open = defineModel<boolean>('isOpen');
const props = defineProps<{
    item: EventItem;
}>();

const formatTime = (time: string) => {
    return new Date(`1970-01-01T${time}`)
        .toLocaleTimeString([], { hour: 'numeric', minute: '2-digit', hour12: true });
};
</script>

<template>
    <Dialog v-model:open="open" class="p-6">

        <DialogContent class="sm:max-500px]">

            <DialogHeader>
                <DialogTitle class="capitalize"> {{ item.title }}</DialogTitle>
                <DialogDescription>
                    {{ item.description }}
                    <p class="mt-4">
                        <span class="font-bold">Time: </span>
                        {{
                            formatTime(item.timeStart) + ' - ' + formatTime(item.timeEnd)
                        }}

                    </p>
                    <p class="mt-4">
                        <span class="font-bold">Date: </span>
                        {{
                            item.date ? dayjs(item.date).format('MMMM D, YYYY') : 'N/A'
                        }}

                    </p>
                </DialogDescription>
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
