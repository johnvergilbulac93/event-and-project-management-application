<script setup lang="ts">
import { CheckIcon, ChevronsUpDownIcon } from 'lucide-vue-next'
import { computed, ref } from 'vue'
import { cn } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from '@/components/ui/command'
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover'

const frameworks = [
    {
        value: 'next.js',
        label: 'Next.js',
    },
    {
        value: 'sveltekit',
        label: 'SvelteKit',
    },
    {
        value: 'nuxt.js',
        label: 'Nuxt.js',
    },
    {
        value: 'remix',
        label: 'Remix',
    },
    {
        value: 'astro',
        label: 'Astro',
    },
]

const props = defineProps({ options: Array });
const open = ref(false)
const value = defineModel<string | number>()

const selectedFramework = computed(() =>
    props.options.find(d => d.value === value.value),
)

function selectFramework(selectedValue: string) {
    value.value = selectedValue === value.value ? '' : selectedValue
    open.value = false
}
</script>

<template>
    <Popover v-model:open="open">
        <PopoverTrigger as-child>
            <Button variant="outline" role="combobox" :aria-expanded="open" class="w-[350px] justify-between">
                {{ selectedFramework?.label || "Select Event..." }}
                <ChevronsUpDownIcon class="opacity-50" />
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-[350px] p-0">
            <Command>
                <CommandInput class="h-9" placeholder="Search Event..." />
                <CommandList>
                    <CommandEmpty>No framework found.</CommandEmpty>
                    <CommandGroup>
                        <CommandItem v-for="option in options" :key="option.value" :value="option.value" @select="(ev) => {
                            selectFramework(ev.detail.value as string)
                        }">
                            {{ option.label }}
                            <CheckIcon :class="cn(
                                'ml-auto',
                                value === option.value ? 'opacity-100' : 'opacity-0',
                            )" />
                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>
