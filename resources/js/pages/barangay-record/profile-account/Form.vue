<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { router, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile Account',
        href: '/barangay-record/profile-account',
    },
];

const props = defineProps({ users: Object });
const title = ref('');
const isAdd = ref(false);
const form = useForm({
    id: '',
    first_name: '',
    middle_name: '',
    last_name: '',
    date_of_birth: '',
    birth_place: '',
    house_no: '',
    street: '',
    purok: '',
    mobile_no: '',
    email: '',
    suffix: '',
    gender: '',
});
function back() {
    router.visit(route('barangay-record.profile-account'), { method: 'get' });
}
function onSubmit() {
    form.post(route('barangay-record.profile-account.store') );
}
function onUpdate() {
    form.put(route('barangay-record.profile-account.update', form.id));
}

onMounted(() => {
    title.value = props.users ? 'Update' : 'Create';
    isAdd.value = !props.users ? true : false;
    if (props.users) {
        form.id = props.users.id;
        form.first_name = props.users.first_name;
        form.middle_name = props.users.middle_name;
        form.last_name = props.users.last_name;
        form.date_of_birth = props.users.date_of_birth;
        form.birth_place = props.users.birth_place;
        form.gender = props.users.gender;
        form.house_no = props.users.house_no;
        form.street = props.users.street;
        form.purok = props.users.purok;
        form.mobile_no = props.users.mobile_no;
        form.email = props.users.email;
        form.suffix = props.users.suffix;
    }
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="`${title} Profile Account`" />
        <div class="px-4 py-6">
            <Heading :title="`${title} Account`" :description="`${title} a profile account`" />
            <form @submit.prevent="isAdd ? onSubmit() : onUpdate()" class="space-y-4">
                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="w-full space-y-2">
                            <Label for="last_name" :class="{ 'text-red-500': form.errors.last_name }">Last Name</Label>
                            <Input
                                id="last_name"
                                type="text"
                                autofocus
                                :tabindex="1"
                                autocomplete="last_name"
                                v-model="form.last_name"
                                placeholder="last name"
                                :class="{ 'border border-red-500': form.errors.last_name }"
                            />
                            <InputError :message="form.errors.last_name" />
                        </div>
                        <div class="w-full space-y-2">
                            <Label for="middle_name" :class="{ 'text-red-500': form.errors.middle_name }">Middle Name</Label>
                            <Input
                                id="middle_name"
                                type="text"
                                autofocus
                                :tabindex="2"
                                autocomplete="middle_name"
                                v-model="form.middle_name"
                                placeholder="middle name"
                                :class="{ 'border border-red-500': form.errors.middle_name }"
                            />
                            <InputError :message="form.errors.middle_name" />
                        </div>
                        <div class="w-full space-y-2">
                            <Label for="first_name" :class="{ 'text-red-500': form.errors.first_name }">First Name</Label>
                            <Input
                                id="first_name"
                                type="text"
                                autofocus
                                :tabindex="3"
                                autocomplete="first_name"
                                v-model="form.first_name"
                                placeholder="first name"
                                :class="{ 'border border-red-500': form.errors.first_name }"
                            />
                            <InputError :message="form.errors.first_name" />
                        </div>
                        <div class="w-full space-y-2">
                            <Label for="suffix">Suffix</Label>
                            <Input
                                id="suffix"
                                type="text"
                                autofocus
                                :tabindex="4"
                                autocomplete="suffix"
                                v-model="form.suffix"
                                placeholder="Jr,Sr,I,II,III,IV"
                            />
                        </div>
                    </div>
                </div>

                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="space-y-2">
                            <Label for="date_of_birth" :class="{ 'text-red-500': form.errors.date_of_birth }">Date of Birth</Label>
                            <Input
                                id="date_of_birth"
                                :class="{ 'border border-red-500': form.errors.date_of_birth }"
                                type="date"
                                autofocus
                                :tabindex="4"
                                autocomplete="date_of_birth"
                                v-model="form.date_of_birth"
                            />
                            <InputError :message="form.errors.date_of_birth" />
                        </div>
                        <div class="space-y-2">
                            <Label for="gender" :class="{ 'text-red-500': form.errors.gender }">Gender</Label>
                            <Select :tabindex="5" v-model="form.gender">
                                <SelectTrigger class="w-[180px]" :class="{ 'border border-red-500': form.errors.gender }" type="date">
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
                            <InputError :message="form.errors.gender" />
                        </div>
                        <div class="w-full space-y-2">
                            <Label for="birth_place" :class="{ 'text-red-500': form.errors.birth_place }">Place of Birth</Label>
                            <Input
                                id="birth_place"
                                type="text"
                                autofocus
                                :tabindex="6"
                                autocomplete="birth_place"
                                v-model="form.birth_place"
                                placeholder="birth place"
                                :class="{ 'border border-red-500': form.errors.birth_place }"
                            />
                            <InputError :message="form.errors.birth_place" />
                        </div>
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="w-full space-y-2">
                            <Label for="email" :class="{ 'text-red-500': form.errors.email }">Email</Label>
                            <Input
                                id="email"
                                type="email"
                                :class="{ 'border border-red-500': form.errors.email }"
                                autofocus
                                :tabindex="7"
                                autocomplete="email"
                                v-model="form.email"
                                placeholder="email"
                            />
                            <InputError :message="form.errors.email" />
                        </div>
                        <div class="w-full space-y-2">
                            <Label for="mobile_no" :class="{ 'text-red-500': form.errors.mobile_no }">Mobile No.</Label>
                            <Input
                                id="mobile_no"
                                type="text"
                                autofocus
                                :tabindex="8"
                                autocomplete="mobile_no"
                                v-model="form.mobile_no"
                                placeholder="mobile no."
                                :class="{ 'border border-red-500': form.errors.mobile_no }"
                            />
                            <InputError :message="form.errors.mobile_no" />
                        </div>
                    </div>
                </div>
                <div class="grid gap-2">
                    <div class="flex w-full gap-2">
                        <div class="w-full space-y-2">
                            <Label for="house_no" :class="{ 'text-red-500': form.errors.house_no }">House No.</Label>
                            <Input
                                id="text"
                                type="text"
                                autofocus
                                :tabindex="9"
                                autocomplete="house_no"
                                v-model="form.house_no"
                                placeholder="house no."
                                :class="{ 'border border-red-500': form.errors.house_no }"
                            />
                            <InputError :message="form.errors.house_no" />
                        </div>
                        <div class="w-full space-y-2">
                            <Label for="street" :class="{ 'text-red-500': form.errors.street }">Street</Label>
                            <Input
                                id="street"
                                type="text"
                                autofocus
                                :tabindex="10"
                                autocomplete="street"
                                v-model="form.street"
                                placeholder="street"
                                :class="{ 'border border-red-500': form.errors.street }"
                            />
                            <InputError :message="form.errors.street" />
                        </div>
                        <div class="w-full space-y-2">
                            <Label for="purok" :class="{ 'text-red-500': form.errors.purok }">Purok</Label>
                            <Input
                                id="purok"
                                :class="{ 'border border-red-500': form.errors.purok }"
                                type="text"
                                autofocus
                                :tabindex="11"
                                autocomplete="purok"
                                v-model="form.purok"
                                placeholder="purok"
                            />
                            <InputError :message="form.errors.purok" />
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
