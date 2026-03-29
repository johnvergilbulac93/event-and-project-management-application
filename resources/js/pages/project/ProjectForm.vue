<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { router, useForm } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput,
} from '@/components/ui/number-field'
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
    project_name: '',
    location: '',
    start_date: '',
    completion_date: '',
    cost: 0,
    image: null,
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
        form.project_name = props.project.project_name;
        form.location = props.project.location;
        form.cost = props.project.cost;
        form.start_date = props.project.start_date;
        form.completion_date = props.project.completion_date;
        // preview.value = props.project.image;
        // form.image = null;
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
                        <Label for="title" :class="{ 'text-red-500': form.errors.project_name }">Name of Project
                        </Label>
                        <Input id="title" type="text" autofocus :tabindex="1" autocomplete="title"
                            v-model="form.project_name"
                            :class="{ 'border border-red-500': form.errors.project_name }" />
                        <InputError :message="form.errors.project_name" />
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="w-full space-y-2">
                        <Label for="title" :class="{ 'text-red-500': form.errors.location }">Location </Label>
                        <Input id="title" type="text" autofocus :tabindex="2" autocomplete="location"
                            v-model="form.location" :class="{ 'border border-red-500': form.errors.location }" />
                        <InputError :message="form.errors.location" />
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="w-full space-y-2">
                        <Label for="title" :class="{ 'text-red-500': form.errors.cost }">Project Cost </Label>
                        <NumberField class="gap-2 w-1/4" v-model="form.cost" :min="0" :format-options="{
                            style: 'currency',
                            currency: 'PHP',
                            currencyDisplay: 'symbol',
                            currencySign: 'accounting',
                        }">
                            <NumberFieldContent>
                                <NumberFieldDecrement />
                                <NumberFieldInput />
                                <NumberFieldIncrement />
                            </NumberFieldContent>
                        </NumberField>

                        <InputError :message="form.errors.cost" />
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="space-y-2">
                            <Label for="start_date" :class="{ 'text-red-500': form.errors.start_date }">Start
                                Date</Label>
                            <Input id="start_date" :class="{ 'border border-red-500': form.errors.start_date }"
                                type="date" autofocus :tabindex="4" autocomplete="start_date"
                                v-model="form.start_date" />
                            <InputError :message="form.errors.start_date" />
                        </div>
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="space-y-2">
                            <Label for="completion_date"
                                :class="{ 'text-red-500': form.errors.completion_date }">Completion Date</Label>
                            <Input id="completion_date"
                                :class="{ 'border border-red-500': form.errors.completion_date }" type="date" autofocus
                                :tabindex="5" autocomplete="completion_date" v-model="form.completion_date" />
                            <InputError :message="form.errors.completion_date" />
                        </div>
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="space-y-2">
                            <Label for="status"> Status</Label>
                            <Select :tabindex="6" v-model="form.status">
                                <SelectTrigger class="w-[180px]"
                                    :class="{ 'border border-red-500': form.errors.status }" type="date">
                                    <SelectValue placeholder="Select a status" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem :value="item.value" v-for="item in statuses" :key="item.value"> {{
                                            item.label }} </SelectItem>
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
