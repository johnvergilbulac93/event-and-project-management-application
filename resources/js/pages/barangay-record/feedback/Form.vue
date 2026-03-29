<script setup lang="ts">
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { Label } from '@/components/ui/label';
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

interface feedbackItem {
    Name: string;
    Email: string;
    Subject: string;
    Comment: string;
}
import dayjs from 'dayjs';
import moment from 'moment';
const open = defineModel<boolean>('isOpen');
const props = defineProps<{
    item: feedbackItem;
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
                <DialogTitle>View Feedback</DialogTitle>
                <DialogDescription>
                    Feedback from <span class="uppercase">{{ item.Name }}</span>
                </DialogDescription>
                <div class="space-y-4 mt-4">
                    <div class="grid gap-2">
                        <Label html-for="name">Name</Label>
                        <Input :tabindex="1" disabled id="name" :default-value="item.Name" type="text" />
                    </div>
                    <div class="grid gap-2">
                        <Label html-for="email">Email</Label>
                        <Input :tabindex="2" disabled id="email" :default-value="item.Email" type="email" />

                    </div>
                    <div class="grid gap-2">
                        <Label html-for="subject">Subject</Label>
                        <Input :tabindex="3" disabled id="subject" :default-value="item.Subject" type="text" />

                    </div>
                    <div class="grid gap-2">
                        <Label html-for="comment">Comment</Label>
                        <Textarea :tabindex="4" disabled id="comment" :default-value="item.Comment" />

                    </div>
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
