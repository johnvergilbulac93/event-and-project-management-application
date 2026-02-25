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
    project_name: '',
    location: '',
    start_date: '',
    completion_date: '',
    cost: 0,
    image: null,
    status: 'Not Started',
});
const preview = ref<string | null>(null);

const handleFileChange = (event: any) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        preview.value = URL.createObjectURL(file);

        if (form.id) {
            updateImage();
        }
    }
};
const updateImage = () => {
    form.post(route('project.update.image', form.id), { preserveScroll: true });
};
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
        form.cost = Number(props.project.cost);
        form.start_date = props.project.start_date;
        form.completion_date = props.project.completion_date;
        preview.value = props.project.image;
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
                        <Label for="title" :class="{ 'text-red-500': form.errors.project_name }">Name of Project </Label>
                        <Input
                            id="title"
                            type="text"
                            autofocus
                            :tabindex="1"
                            autocomplete="title"
                            v-model="form.project_name"
                            :class="{ 'border border-red-500': form.errors.project_name }"
                        />
                        <InputError :message="form.errors.project_name" />
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="w-full space-y-2">
                        <Label for="title" :class="{ 'text-red-500': form.errors.location }">Location </Label>
                        <Input
                            id="title"
                            type="text"
                            autofocus
                            :tabindex="2"
                            autocomplete="location"
                            v-model="form.location"
                            :class="{ 'border border-red-500': form.errors.location }"
                        />
                        <InputError :message="form.errors.location" />
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="w-full space-y-2">
                        <Label for="title" :class="{ 'text-red-500': form.errors.cost }">Project Cost </Label>
                        <Input
                            id="title"
                            type="number"
                            autofocus
                            :tabindex="3"
                            autocomplete="cost"
                            v-model="form.cost"
                            class="w-1/2 sm:w-full"
                            :class="{ 'border border-red-500': form.errors.cost }"
                        />
                        <InputError :message="form.errors.cost" />
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
                                :tabindex="4"
                                autocomplete="start_date"
                                v-model="form.start_date"
                            />
                            <InputError :message="form.errors.start_date" />
                        </div>
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="space-y-2">
                            <Label for="completion_date" :class="{ 'text-red-500': form.errors.completion_date }">Completion Date</Label>
                            <Input
                                id="completion_date"
                                :class="{ 'border border-red-500': form.errors.completion_date }"
                                type="date"
                                autofocus
                                :tabindex="5"
                                autocomplete="completion_date"
                                v-model="form.completion_date"
                            />
                            <InputError :message="form.errors.completion_date" />
                        </div>
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="space-y-2">
                            <Label for="status"> Status</Label>
                            <Select :tabindex="6" v-model="form.status">
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
                <div class="grid gap-2">
                    <div class="w-1/4 space-y-2">
                        <Label for="title">Image</Label>
                        <input
                            @change="handleFileChange"
                            accept="image/png, image/jpeg, image/jpg"
                            type="file"
                            class="cursor-pointer rounded border p-1 text-sm file:mr-4 file:rounded file:border file:bg-primary file:p-0.5 file:px-4 file:font-medium file:text-white"
                        />
                    </div>
                    <div v-if="preview" class="mt-4">
                        <img :src="preview" class="h-48 rounded shadow" />
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
