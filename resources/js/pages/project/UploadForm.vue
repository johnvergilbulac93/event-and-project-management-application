<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { ref } from 'vue';
const open = defineModel<boolean>('isOpen');
const props = defineProps({ id: String });
const emit = defineEmits(['close']);

const form = useForm({
    image: null,
    fileName: '',
});
const handleFileChange = (event: any) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        // preview.value = URL.createObjectURL(file);
        form.fileName = file.name;

        if (props.id) {
            updateImage();
        }
    }
};
const updateImage = () => {
    form.post(route('project.update.image', props.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit('close');
            toast.success('Image updated successfully!');
            form.reset();
        }
    });
};
</script>

<template>
    <Dialog v-model:open="open" class="p-6">

        <DialogContent class="sm:max-500px]">
            <DialogHeader>
                <DialogTitle>Change Image</DialogTitle>
                <DialogDescription>
                    Select an image to upload for this project.
                </DialogDescription>

                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 bg-gray-50 border border-dashed  rounded cursor-pointer hover:bg-gray-100 transition duration-300">
                        <div class="flex flex-col items-center justify-center text-body pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 17h3a3 3 0 0 0 0-6h-.025a5.56 5.56 0 0 0 .025-.5A5.5 5.5 0 0 0 7.207 9.021C7.137 9.017 7.071 9 7 9a4 4 0 1 0 0 8h2.167M12 19v-9m0 0-2 2m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm"><span class="font-semibold">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs">PNG, JPG or GIF</p>
                        </div>
                        <input id="dropzone-file" @change="handleFileChange" type="file" class="hidden" />
                    </label>
                </div>
                <small>{{ form.fileName }}</small>

            </DialogHeader>
            <DialogFooter>
                <DialogClose as-child>
                    <Button variant="outline">
                        Close
                    </Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
