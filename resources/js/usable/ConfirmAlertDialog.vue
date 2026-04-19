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
} from '@/components/ui/alert-dialog'

defineProps({ description: { type: String, default: 'This action cannot be undone. This will permanently deleted.' } });

const visible = defineModel<boolean>('visible')
const emit = defineEmits(['continue'])
</script>

<template>
  <AlertDialog v-model:open="visible">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
        <AlertDialogDescription>
          {{ description }}
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel @click="visible = false">Cancel</AlertDialogCancel>
        <AlertDialogAction @click="emit('continue')">Continue</AlertDialogAction>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>
