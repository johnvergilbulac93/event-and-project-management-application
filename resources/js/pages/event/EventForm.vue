<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { router, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manage Event',
        href: '/event/create',
    },
];

const props = defineProps({ events: Object });
const title = ref('');
const isAdd = ref(false);
const form = useForm({
    id: '',
    title: '',
    description: '',
    start_time: '',
    end_time: '',
    date: '',
    status: true,
});
function back() {
    router.visit(route('event.index'), { method: 'get' });
}
function onSubmit() {
    form.post(route('event.store'), { onSuccess: () => form.reset() });
}
function onUpdate() {
    form.put(route('event.update', form.id));
}

onMounted(() => {
    title.value = props.events ? 'Update' : 'Create';
    isAdd.value = !props.events ? true : false;
    if (props.events) {
        form.id = props.events.id;
        form.title = props.events.title;
        form.description = props.events.description;
        form.start_time = props.events.start_time;
        form.end_time = props.events.end_time;
        form.date = props.events.date;
        form.status = props.events.status == 1 ? true : false;
    }
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="`${title} Event`" />
        <div class="px-4 py-6">
            <Heading :title="`${title} Event`" :description="`${title} a event`" />
            <form @submit.prevent="isAdd ? onSubmit() : onUpdate()" class="space-y-4">
                <div class="grid gap-2">
                    <div class="w-full space-y-2">
                        <Label for="title" :class="{ 'text-red-500': form.errors.title }">Event Title</Label>
                        <Input
                            id="title"
                            type="text"
                            autofocus
                            :tabindex="1"
                            autocomplete="title"
                            v-model="form.title"
                            placeholder=" Type event title"
                            :class="{ 'border border-red-500': form.errors.title }"
                        />
                        <InputError :message="form.errors.title" />
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="w-full space-y-2">
                        <Label for="description" :class="{ 'text-red-500': form.errors.description }">Event Description</Label>
                        <Textarea :tabindex="2" v-model="form.description" placeholder="Type your description here." />
                        <InputError :message="form.errors.description" />
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="space-y-2">
                            <Label for="date" :class="{ 'text-red-500': form.errors.date }">Date of Event</Label>
                            <Input
                                id="date"
                                :class="{ 'border border-red-500': form.errors.date }"
                                type="date"
                                autofocus
                                :tabindex="3"
                                autocomplete="date"
                                v-model="form.date"
                            />
                            <InputError :message="form.errors.date" />
                        </div>
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="space-y-2">
                            <Label for="start_time" :class="{ 'text-red-500': form.errors.start_time }">Start time</Label>
                            <Input
                                id="date"
                                :class="{ 'border border-red-500': form.errors.start_time }"
                                type="time"
                                autofocus
                                :tabindex="4"
                                autocomplete="start_time"
                                v-model="form.start_time"
                            />
                            <InputError :message="form.errors.start_time" />
                        </div>
                        <div class="space-y-2">
                            <Label for="end_time" :class="{ 'text-red-500': form.errors.end_time }">End time</Label>
                            <Input
                                id="end_time"
                                :class="{ 'border border-red-500': form.errors.end_time }"
                                type="time"
                                autofocus
                                :tabindex="5"
                                autocomplete="end_time"
                                v-model="form.end_time"
                            />
                            <InputError :message="form.errors.end_time" />
                        </div>
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="space-y-2">
                            <Label for="status">Event Status</Label>
                            <Switch :tabindex="6" v-model="form.status" id="status" />
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <Button tabindex="13" size="sm" type="button" @click="back"> Back </Button>
                    <Button tabindex="12" size="sm" type="submit"> Submit </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
