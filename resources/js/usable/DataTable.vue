<script setup lang="ts">
import { Separator } from '@/components/ui/separator';

import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuCheckboxItem, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { valueUpdater } from '@/components/ui/table/utils';
import type { ColumnDef, ColumnFiltersState, ExpandedState, SortingState, VisibilityState } from '@tanstack/vue-table';
import debounce from 'lodash.debounce';

import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { FlexRender, getCoreRowModel, getExpandedRowModel, getFilteredRowModel, getSortedRowModel, useVueTable } from '@tanstack/vue-table';

// import {
//     Pagination,
//     PaginationEllipsis,
//     PaginationFirst,
//     PaginationLast,
//     PaginationListItem,
//     PaginationNext,
//     PaginationPrev,
// } from '@/components/ui/pagination';

import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import { ChevronDown, Database, Plus } from 'lucide-vue-next';
import { computed, h, reactive, ref, toRefs, watch } from 'vue';
import DropdownAction from './DrowdownAction.vue';

interface Pagination {
    current_page: number;
    from: number;
    last_page: number;
    per_page: number;
    to: number;
    total: number;
    name: string;
    label?: string;
    links: [];
}

const props = defineProps<{
    title: string;
    items: any[];
    // pagination: Pagination;
    columns: ColumnDef<any>[];
    showDelete: true;
}>();

// const emit = defineEmits(['filter', 'edit', 'delete', 'create']);

const form = reactive({
    page: 1,
    limit: '10',
    search: '',
});
const { page, limit, search } = toRefs(form);
function pageChange(value: number) {
    page.value = value;
    // filter();
}

// const filter = debounce(() => {
//     emit('filter', form);
// }, 200);

watch([search, limit], () => {
    form.page = 1;
    // filter();x
});

const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);
const columnVisibility = ref<VisibilityState>({});
const rowSelection = ref({});
const expanded = ref<ExpandedState>({});

const table = useVueTable({
    get data() {
        return props.items;
    },
    get columns() {
        return [
            ...props.columns,
            {
                id: 'actions',
                header: 'Actions',
                cell: ({ row }) => {
                    const record = row.original;
                    return h(DropdownAction, {
                        showDelete: props.showDelete,
                        // onEdit: () => emit('edit', record),
                        // onDelete: () => emit('delete', record),
                        // onExpand: row.toggleExpanded,
                    });
                },
                enableHiding: false,
            },
        ];
    },
    getCoreRowModel: getCoreRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: (updaterOrValue) => valueUpdater(updaterOrValue, rowSelection),
    onExpandedChange: (updaterOrValue) => valueUpdater(updaterOrValue, expanded),
    state: {
        get sorting() {
            return sorting.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
        get columnVisibility() {
            return columnVisibility.value;
        },
        get rowSelection() {
            return rowSelection.value;
        },
        get expanded() {
            return expanded.value;
        },
    },
});
const selectedRows = computed(() => {
    return table.getSelectedRowModel().rows.map((row) => row.original.id);
});
</script>
<template>
    <div class="px-4">
        <h2 class="text-xl font-semibold tracking-tight">{{ title }}</h2>
        <!-- <p class="text-muted-foreground text-sm">Create new incident</p> -->
    </div>
    <Separator class="mt-4" />
    <div class="m-2">
        <div class="flex items-center gap-2 py-4">
            <!-- <Input
        class="max-w-sm"
        placeholder="Filter emails..."
        :model-value="table.getColumn('email')?.getFilterValue() as string"
        @update:model-value="table.getColumn('email')?.setFilterValue($event)"
      /> -->
            <Input
                class="max-w-sm"
                placeholder="search"
                v-model="form.search"
                @input="
                    debounce(() => {
                        form.search = $event.target.value;
                    })
                "
            />
            <TooltipProvider>
                <Tooltip>
                    <TooltipTrigger as-child>
                        <Button @click="emit('create')"><Plus /></Button>
                    </TooltipTrigger>
                    <TooltipContent>
                        <p>Create new record</p>
                    </TooltipContent>
                </Tooltip>
            </TooltipProvider>

            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button variant="outline" class="ml-auto"> Columns <ChevronDown class="ml-2 h-4 w-4" /> </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                    <DropdownMenuCheckboxItem
                        v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
                        :key="column.id"
                        class="capitalize"
                        :model-value="column.getIsVisible()"
                        @update:model-value="
                            (value) => {
                                column.toggleVisibility(!!value);
                            }
                        "
                    >
                        {{ column.id }}
                    </DropdownMenuCheckboxItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
        <div class="rounded-md border">
            <Table>
                <TableHeader>
                    <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead v-for="header in headerGroup.headers" :key="header.id">
                            <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="items.length">
                        <template v-for="row in table.getRowModel().rows" :key="row.id">
                            <TableRow :data-state="row.getIsSelected() && 'selected'">
                                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="row.getIsExpanded()">
                                <TableCell :colspan="row.getAllCells().length">
                                    {{ JSON.stringify(row.original) }}
                                </TableCell>
                            </TableRow>
                        </template>
                    </template>

                    <TableRow v-else>
                        <TableCell :colspan="columns.length + 1" class="h-24 text-muted-foreground">
                            <div class="flex h-full w-full flex-col items-center justify-center gap-2">
                                <Database class="h-6 w-6" />
                                <p>No Data</p>
                            </div>
                            <!-- <span class="text-center">No Record Found <Database /> </span> -->
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <div class="flex items-center justify-between space-x-2 py-2" >
            <!-- <div class="flex w-1/2 items-center gap-2 text-sm text-muted-foreground">
                {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} row(s) selected.
                <div class="w-[80px]">
                    <Select v-model="form.limit">
                        <SelectTrigger>
                            <SelectValue placeholder="Per Page" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Page</SelectLabel>
                                <SelectItem value="10"> 10 </SelectItem>
                                <SelectItem value="50">50 </SelectItem>
                                <SelectItem value="100"> 100 </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
            </div> -->
            <!-- <Pagination
                v-slot="{ page }"
                :items-per-page="Number(form.limit)"
                :total="pagination.total"
                :sibling-count="1"
                show-edges
                :default-page="pagination.current_page"
            >
                <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                    <PaginationFirst @click="pageChange(pagination.current_page)" />
                    <PaginationPrev @click="pageChange(form.page - 1)" />
                    <template v-for="(item, index) in items">
                        <PaginationListItem v-if="item.type === 'page'" :key="index" :value="item.value" as-child>
                            <Button class="h-10 w-10 p-0" @click="pageChange(item.value)" :variant="item.value === page ? 'default' : 'outline'">
                                {{ item.value }}
                            </Button>
                        </PaginationListItem>
                        <PaginationEllipsis v-else :key="item.type" :index="index" />
                    </template>

                    <PaginationNext @click="pageChange(form.page + 1)" />
                    <PaginationLast @click="pageChange(pagination.last_page)" />
                </PaginationList>
            </Pagination> -->
            <!-- <div class="flex-1 text-sm text-muted-foreground">
        {{ table.getFilteredSelectedRowModel().rows.length }} of
        {{ table.getFilteredRowModel().rows.length }} row(s) selected.
      </div>
      <div class="space-x-2">
        <Button
          variant="outline"
          size="sm"
          :disabled="!table.getCanPreviousPage()"
          @click="table.previousPage()"
        >
          Previous
        </Button>
        <Button
          variant="outline"
          size="sm"
          :disabled="!table.getCanNextPage()"
          @click="table.nextPage()"
        >
          Next
        </Button>
      </div> -->
        </div>
    </div>
</template>

<style lang="scss" scoped></style>
