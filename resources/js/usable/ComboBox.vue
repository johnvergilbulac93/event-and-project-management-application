<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Combobox,
    ComboboxAnchor,
    ComboboxEmpty,
    ComboboxGroup,
    ComboboxInput,
    ComboboxItem,
    ComboboxItemIndicator,
    ComboboxList,
    ComboboxTrigger,
} from '@/components/ui/combobox';
import { cn } from '@/lib/utils';
import { Check, ChevronsUpDown, Search } from 'lucide-vue-next';

const props = defineProps({ options: Object, label: String });
const modelValue = defineModel();
</script>

<template>
    <Combobox v-model="modelValue" by="label">
        <ComboboxAnchor as-child>
            <ComboboxTrigger as-child>
                <Button variant="outline" class="justify-between">
                    {{ modelValue?.label ?? label }}

                    <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                </Button>
            </ComboboxTrigger>
        </ComboboxAnchor>

        <ComboboxList>
            <div class="relative w-full max-w-sm items-center">
                <ComboboxInput class="h-10 rounded-none border-0 focus-visible:ring-0" :placeholder="label" />
                <span class="absolute inset-y-0 start-0 flex items-center justify-center px-3">
                    <Search class="size-4 text-muted-foreground" />
                </span>
            </div>

            <ComboboxEmpty> No result found. </ComboboxEmpty>

            <ComboboxGroup>
                <ComboboxItem v-for="option in options" :key="option.value" :value="option.value">
                    {{ option.label }}

                    <ComboboxItemIndicator>
                        <Check :class="cn('ml-auto h-4 w-4')" />
                    </ComboboxItemIndicator>
                </ComboboxItem>
            </ComboboxGroup>
        </ComboboxList>
    </Combobox>
</template>
