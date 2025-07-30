<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { User, type BreadcrumbItem } from '@/types';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import { toPng } from 'html-to-image';
import { ref } from 'vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'My Qr Code',
        href: '/settings/qr-code',
    },
];
const page = usePage();
const user = page.props.auth.user as User;

const userInput = ref(user.email);

const downloading = ref(false);

const templateReference = ref(null);

const downloadQRCode = () => {
    if (templateReference.value === null) {
        return;
    }

    downloading.value = true;

    toPng(templateReference.value)
        .then((dataUrl) => {
            const link = document.createElement('a');
            link.download = 'my-qrcode.png';
            link.href = dataUrl;
            link.click();
            downloading.value = false;
        })
        .catch((err) => {
            console.log(err, templateReference.value);
            downloading.value = false;
        });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="My Qr Code" />

        <SettingsLayout>
            <HeadingSmall title="My Qr Code" description="Present this QR Code for events attendance" />
            <Button @click="downloadQRCode">Download QR Code</Button>

            <div class="flex items-center justify-center" ref="templateReference">
                <vue-qrcode
                    :value="userInput"
                    :options="{
                        width: 400,
                        color: { dark: '#20A418', light: '#ffffff' },
                    }"
                ></vue-qrcode>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
