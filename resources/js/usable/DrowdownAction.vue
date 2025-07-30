<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { MoreHorizontal, Trash2, Pencil } from 'lucide-vue-next'

defineProps<{
  showDelete: boolean
}>()

const emit = defineEmits(['edit', 'delete'])

function copy(id: string) {
  navigator.clipboard.writeText(id)
}
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" class="w-8 h-8 p-0">
        <span class="sr-only">Open menu</span>
        <MoreHorizontal class="w-4 h-4" />
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end">
      <DropdownMenuLabel>Actions</DropdownMenuLabel>
      <!-- <DropdownMenuItem @click="copy(user.id)"> Copy payment ID </DropdownMenuItem>
      <DropdownMenuSeparator /> -->
      <DropdownMenuItem @click="emit('edit')" class="focus:text-blue-500 cursor-pointer"
        ><Pencil /> Edit</DropdownMenuItem
      >
      <DropdownMenuItem
        @click="emit('delete')"
        class="focus:text-red-500 cursor-pointer"
      >
        <Trash2 />Delete</DropdownMenuItem
      >
    </DropdownMenuContent>
  </DropdownMenu>
</template>
