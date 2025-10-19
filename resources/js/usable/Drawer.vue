<script lang="ts" setup>
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';

import { createReusableTemplate, useMediaQuery } from '@vueuse/core';

// Reuse `form` section
const [UseTemplate, GridForm] = createReusableTemplate();
const isDesktop = useMediaQuery('(min-width: 768px)');
const open = defineModel<boolean>('isOpen');
const emit = defineEmits(['save'])
const props = defineProps({ title: { type: String, default: 'Title'}, description: { type: String, default: ''}})
</script>

<template>


    <Dialog v-model:open="open">
        <DialogContent class="w-[600px]">
            <DialogHeader>
                <DialogTitle>{{ title }}</DialogTitle>
                <DialogDescription> {{ description }} </DialogDescription>
            </DialogHeader>
            <slot/>
        </DialogContent>
    </Dialog>
</template>
