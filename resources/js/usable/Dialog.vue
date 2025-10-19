<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';

const visible2 = defineModel<boolean>('visible2');
const emit = defineEmits(['ok']);
defineProps({ title: { type: String, default: 'Title Here' }, buttonText: { type: String, default: 'Ok' } });
</script>

<template>
    <AlertDialog v-model:open="visible2">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>{{ title }}</AlertDialogTitle>
                <AlertDialogDescription> <slot /> </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel @click="visible2 = false">Cancel</AlertDialogCancel>
                <AlertDialogAction @click="emit('ok')">{{ buttonText }}</AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
