<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import axios from 'axios';
import debounce from 'lodash.debounce';
import { reactive, ref } from 'vue';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manage Attendance',
        href: '/attendance/create',
    },
];
const props = defineProps({ event: Object });

const form = reactive({
    id: '',
    name: '',
    result: '',
});
const inputRef = ref<HTMLInputElement | null>(null);

const result = ref('');
function onDetect(detectedCodes: any) {
    console.log(detectedCodes);
    result.value = JSON.stringify(detectedCodes.map((code: any) => code.rawValue));
}

const getUser = async (email: string) => {
    try {
        const { data, status } = await axios.post(`/attendance`, { email: email, event_id: props.event?.id });
        form.name = data.user.full_name;
        toast.success(data.message);

    } catch (error) {
        toast.error(error?.response.data.message);
    }
};

const onChange = debounce(() => {
    getUser(form.result);
    form.result = '';
}, 200);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="QR Scanner Attendance" />
        <Toaster richColors position="top-right" />
        <div class="px-4 py-6">
            <Heading title="Attendance QR Code Scanner" description="Check attendees" />
            <h2 class="text-xl font-bold">{{ event?.title }}</h2>
            <div class="mt-4 w-full">
                <Input
                    ref="inputRef"
                    type="password"
                    @keyup="onChange"
                    v-model="form.result"
                    autofocus
                    placeholder="Put the cursor here and scan the qr code"
                />
                <p v-if="form.name" class="mt-4 text-xl font-bold">Latest Scan Attendee: &nbsp;{{ form.name }}</p>
            </div>
        </div>
    </AppLayout>
</template>
