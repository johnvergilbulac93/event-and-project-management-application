<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import Modal from '@/usable/Modal.vue';
import ModalProject from '@/usable/ModalProject.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import Autoplay from 'embla-carousel-autoplay';
import debounce from 'lodash.debounce';
import { onMounted, reactive, ref } from 'vue';
import { toast } from 'vue-sonner';

const plugin = Autoplay({
    delay: 3000,
    stopOnMouseEnter: true,
    stopOnInteraction: false,
});

interface EventItem {
    title: string;
    description: string;
    timeStart: string;
    timeEnd: string;
    date: string;

}
interface ProjectItem {
    name: string;
    location: string;
    cost: string;
    start_date: string;
    completion_date: string;
    status: string;
    url: string;
}
const SelectedItem = reactive<EventItem>({
    title: '',
    description: '',
    timeStart: '',
    timeEnd: '',
    date: '',
});
const SelectedProjectItem = reactive<ProjectItem>({
    name: '',
    location: '',
    cost: '',
    start_date: '',
    completion_date: '',
    status: '',
    url: '',
});
const scrollToSection = (id: string) => {
    const el = document.getElementById(id);
    if (el) {
        el.scrollIntoView({
            behavior: 'smooth',
            block: 'center', // 👈 this makes it centered
        });
        history.pushState(null, '', `#${id}`);
    }
};
const menus = [
    {
        name: 'Home',
        path: 'home',
    },

    {
        name: 'Events',
        path: 'events',
    },
    {
        name: 'Projects',
        path: 'projects',
    },
    {
        name: 'Feedbacks',
        path: 'feedbacks',
    },
    {
        name: 'About Us',
        path: 'about_us',
    },
];
const events = ref([]);
const projects = ref([]);
const eventNextPageUrl = ref('/home/events'); // your route for fetching
const projectNextPageUrl = ref('/home/projects'); // your route for fetching
const openEventModal = ref(false);
const openProjectModal = ref(false);
const form = useForm({
    name: '',
    email: '',
    subject: '',
    comment: '',
});
const getEvents = debounce(async () => {
    if (!eventNextPageUrl.value) return;
    const { data } = await axios.get(eventNextPageUrl.value);

    // append records
    events.value.push(...data.data);

    // update next page
    eventNextPageUrl.value = data.next_page_url;
}, 200);

const getProjects = debounce(async () => {
    if (!projectNextPageUrl.value) return;
    const { data } = await axios.get(projectNextPageUrl.value);

    // append records
    projects.value.push(...data.data);

    // update next page
    projectNextPageUrl.value = data.next_page_url;
}, 200);

const handleClickEventModal = (item: any) => {
    openEventModal.value = true;
    SelectedItem.title = item.title;
    SelectedItem.description = item.description;
    SelectedItem.timeStart = item.start_time;
    SelectedItem.timeEnd = item.end_time;
    SelectedItem.date = item.date;
};
const handleClickProjectModal = (item: any) => {
    openProjectModal.value = true;
    SelectedProjectItem.name = item.project_name;
    SelectedProjectItem.location = item.location;
    SelectedProjectItem.cost = item.cost;
    SelectedProjectItem.start_date = item.start_date;
    SelectedProjectItem.completion_date = item.completion_date;
    SelectedProjectItem.status = item.status;
    SelectedProjectItem.url = item.image;

};

const goTo = () => {
    router.visit(route('login'));
};
const onSubmit = () => {
    form.post(route('feedback.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Thank you, form submitted.');
            form.reset();
        },
    });
};
onMounted(() => {
    getEvents();
    getProjects();
});
</script>

<template>

    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <Toaster closeButton="true" closeButtonPosition="top-right" position="bottom-right" />

    <div>
        <header
            class="  border-grid sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
            <div class=" mx-4 flex h-16 items-center justify-between">
                <a href="" class="flex items-center gap-2">
                    <img src="/images/logo.png" class="h-14" alt="logo" />
                    <span class="font-bold uppercase">Tiptip Event & Project Management System</span>
                </a>
                <nav class="space-x-1 font-bold uppercase">
                    <a href="#" @click.prevent="scrollToSection(value.path)" v-for="value in menus"
                        class="p-2 transition duration-300 hover:bg-primary/90 hover:text-white">{{ value.name }}</a>
                </nav>
                <!-- <Button @click="goTo" class="font-bold uppercase">Login</Button> -->
            </div>
        </header>

        <section id="home"
            class="bg-gray-300 bg-[url('/images/bg-login.png')] bg-center bg-no-repeat bg-blend-multiply">
            <div class="mx-auto max-w-screen-xl px-4 py-24 text-center lg:py-56">
                <h1
                    class="mb-4 text-4xl leading-none font-extrabold tracking-tight text-white capitalize md:text-5xl lg:text-6xl">
                    Tiptip Event and Project Management System
                </h1>
                <p class="mb-8 text-lg font-normal text-gray-300 sm:px-16 lg:px-48 lg:text-xl">
                    <!-- We are dedicated to creating smarter ways to plan, manage, and execute projects and events—unlocking value through efficiency and
                    innovation. -->
                    Through this initiative, the community of Barangay Tiptip will be able to improve meeting
                    organization, project management, and
                    community participation and compliance.
                </p>
            </div>
        </section>
        <section id="events" class="bg-gray-100 p-8">
            <h2 class="mb-4 text-center text-3xl font-bold text-primary md:text-4xl">Events</h2>
            <div class="flex flex-wrap justify-center gap-4">
                <div v-for="item in events" :key="item"
                    class="flex flex-col items-center  bg-white p-6 border rounded shadow-xs md:flex-row md:max-w-xl md:flex-row md:max-w-xl">
                    <img class="object-cover w-full rounded-base h-64 md:h-auto md:w-48 mb-4 md:mb-0"
                        src="/images/logo.png" alt="">
                    <div class="flex flex-col justify-between md:p-4 leading-normal">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-heading">{{ item.title }}</h5>
                        <div>
                            <Button type="button" @click="handleClickEventModal(item)"
                                class="inline-flex cursor-pointer items-center w-auto text-body bg-neutral-secondary-medium box-border border  hover:bg-gray-100 hover:text-heading  shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                Read more
                                <svg class="w-4 h-4 ms-1.5 rtl:rotate-180 -me-0.5" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                                </svg>
                            </Button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="mt-4 flex items-center justify-center">
                <Button v-if="eventNextPageUrl" @click="getEvents">See More</Button>
            </div>
        </section>
        <section id="projects" class="p-8">
            <h2 class="mb-4 text-center text-3xl font-bold text-primary md:text-4xl">Projects</h2>

            <div class="flex flex-wrap justify-center gap-4">



                <div class="bg-neutral-primary-soft block w-[350px] border border-default rounded shadow-xs"
                    v-for="item in projects" :key="item">
                    <img class="rounded-t w-full h-48 object-cover" :src="item.image || '/images/logo.png'"
                        alt="project-images" />
                    <div class="p-6 text-center">
                        <span
                            class="inline-flex items-center bg-gray-50  border text-xs font-medium px-1.5 py-0.5 rounded-sm">

                            {{ item.status }}
                        </span>
                        <a href="#">
                            <h5 class="mt-3 mb-6 text-2xl font-semibold tracking-tight text-heading capitalize ">{{
                                item.project_name }}</h5>
                        </a>
                        <Button variant="secondary" @click="handleClickProjectModal(item)"
                            class="inline-flex items-center cursor-pointer bg-brand box-border border border-rounded  shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                            Read more
                            <svg class="w-4 h-4 ms-1.5 rtl:rotate-180 -me-0.5" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                            </svg>
                        </Button>
                    </div>
                </div>

            </div>
            <div class="mt-4 flex items-center justify-center">
                <Button v-if="projectNextPageUrl" @click="getProjects">See More</Button>
            </div>
        </section>

        <section id="feedbacks" class="flex items-center justify-center bg-gray-100 p-8">
            <form @submit.prevent="onSubmit()" class="grid w-1/2 items-start gap-4 px-4">
                <h2 class="text-center text-3xl font-bold text-primary md:text-4xl">Feedback Form</h2>
                <div class="grid gap-2">
                    <Label html-for="name" class="font-bold">Name</Label>
                    <Input :class="{ 'border border-red-500': form.errors.name }" v-model="form.name" :tabindex="1"
                        id="name" type="text" />
                    <InputError :message="form.errors.name" />
                </div>
                <div class="grid gap-2">
                    <Label html-for="email" class="font-bold">Email</Label>
                    <Input :class="{ 'border border-red-500': form.errors.email }" v-model="form.email" :tabindex="2"
                        id="email" type="email" />
                    <InputError :message="form.errors.email" />
                </div>
                <div class="grid gap-2">
                    <Label html-for="subject" class="font-bold">Subject</Label>
                    <Input :class="{ 'border border-red-500': form.errors.subject }" v-model="form.subject"
                        :tabindex="3" id="subject" type="text" />
                    <InputError :message="form.errors.subject" />
                </div>
                <div class="grid gap-2">
                    <Label html-for="comment" class="font-bold">Comment</Label>
                    <Textarea :class="{ 'border border-red-500': form.errors.comment }" v-model="form.comment"
                        :tabindex="4" id="comment" />
                    <InputError :message="form.errors.comment" />
                </div>
                <Button type="submit" class="cursor-pointer"> Submit </Button>
            </form>
        </section>
        <section id="about_us"
            class="flex min-h-screen items-center justify-center bg-gradient-to-b from-white to-primary/10 px-6 py-16">
            <div class="max-w-4xl space-y-2 text-center">
                <h2 class="text-3xl font-bold text-primary md:text-4xl">About Us</h2>
                <p class="text-lg text-gray-600">
                    The Barangay Event and Project Management System is built to help local communities organize and
                    oversee their programs, projects,
                    and events more effectively. From small gatherings to large-scale barangay initiatives, our platform
                    provides tools that improve
                    coordination, transparency, and participation.
                </p>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    <div class="rounded-2xl bg-white p-6 shadow">
                        <h3 class="text-xl font-semibold text-primary">Community Events</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Easily plan barangay assemblies, sports activities, health programs, and cultural events
                            with organized schedules.
                        </p>
                    </div>
                    <div class="rounded-2xl bg-white p-6 shadow">
                        <h3 class="text-xl font-semibold text-primary">Project Monitoring</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Track the progress of barangay projects such as infrastructure, livelihood, and development
                            programs in real time.
                        </p>
                    </div>
                    <div class="rounded-2xl bg-white p-6 shadow">
                        <h3 class="text-xl font-semibold text-primary">Transparency & Reports</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Generate reports, improve accountability, and keep the community informed about ongoing and
                            completed activities.
                        </p>
                    </div>
                </div>

                <p class="text-lg text-gray-600">
                    With this system, barangays can strengthen governance, foster active community participation, and
                    ensure that projects and events
                    create meaningful impact.
                </p>
            </div>
        </section>
        <Modal v-model:open="openEventModal" :item="SelectedItem" />
        <ModalProject v-model:open="openProjectModal" :item="SelectedProjectItem" />

    </div>
</template>

<style>
html {
    scroll-behavior: smooth;
}
</style>
