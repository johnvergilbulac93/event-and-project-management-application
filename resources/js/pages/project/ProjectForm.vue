<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { router, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manage Project',
        href: '/project/create',
    },
];

const statuses = [
    {
        label: 'Not Started',
        value: 'Not Started',
    },
    {
        label: 'In Progress',
        value: 'In Progress',
    },
    {
        label: 'On Hold',
        value: 'On Hold',
    },
    {
        label: 'Completed',
        value: 'Completed',
    },
    {
        label: 'Cancelled',
        value: 'Cancelled',
    },
    {
        label: 'Archived',
        value: 'Archived',
    },
];

const props = defineProps({ project: Object });
const title = ref('');
const isAdd = ref(false);
const form = useForm({
    id: '',
    title: '',
    description: '',
    start_date: '',
    end_date: '',
    status: 'Not Started',
});
function back() {
    router.visit(route('project.index'), { method: 'get' });
}
function onSubmit() {
    form.post(route('project.store'), { onSuccess: () => form.reset() });
}
function onUpdate() {
    form.put(route('project.update', form.id));
}

onMounted(() => {
    title.value = props.project ? 'Update' : 'Create';
    isAdd.value = !props.project ? true : false;
    if (props.project) {
        form.id = props.project.id;
        form.title = props.project.title;
        form.description = props.project.description;
        form.start_date = props.project.start_date;
        form.end_date = props.project.end_date;
        form.status = props.project.status;

    }
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="`${title} Project`" />
        <div class="px-4 py-6">
            <Heading :title="`${title} Project`" :description="`${title} a project`" />
            <form @submit.prevent="isAdd ? onSubmit() : onUpdate()" class="space-y-4">
                <div class="grid gap-2">
                    <div class="w-full space-y-2">
                        <Label for="title" :class="{ 'text-red-500': form.errors.title }">Project Title</Label>
                        <Input
                            id="title"
                            type="text"
                            autofocus
                            :tabindex="1"
                            autocomplete="title"
                            v-model="form.title"
                            placeholder=" Type project title here"
                            :class="{ 'border border-red-500': form.errors.title }"
                        />
                        <InputError :message="form.errors.title" />
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="w-full space-y-2">
                        <Label for="description" :class="{ 'text-red-500': form.errors.description }">Project Description</Label>
                        <Textarea :tabindex="2" v-model="form.description" placeholder="Type your description here." />
                        <InputError :message="form.errors.description" />
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="space-y-2">
                            <Label for="start_date" :class="{ 'text-red-500': form.errors.start_date }">Start Date</Label>
                            <Input
                                id="start_date"
                                :class="{ 'border border-red-500': form.errors.start_date }"
                                type="date"
                                autofocus
                                :tabindex="3"
                                autocomplete="start_date"
                                v-model="form.start_date"
                            />
                            <InputError :message="form.errors.start_date" />
                        </div>
                        <div class="space-y-2">
                            <Label for="end_date" :class="{ 'text-red-500': form.errors.end_date }">End Date</Label>
                            <Input
                                id="end_date"
                                :class="{ 'border border-red-500': form.errors.end_date }"
                                type="date"
                                autofocus
                                :tabindex="4"
                                autocomplete="end_date"
                                v-model="form.end_date"
                            />
                            <InputError :message="form.errors.end_date" />
                        </div>
                    </div>
                </div>

                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="space-y-2">
                            <Label for="status"> Status</Label>
                            <Select :tabindex="5" v-model="form.status">
                                <SelectTrigger class="w-[180px]" :class="{ 'border border-red-500': form.errors.status }" type="date">
                                    <SelectValue placeholder="Select a status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem :value="item.value" v-for="item in statuses" :key="item.value"> {{ item.label }} </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.status" />
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <Button tabindex="6" size="sm" type="button" @click="back"> Back </Button>
                    <Button tabindex="7" size="sm" type="submit"> Submit </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
