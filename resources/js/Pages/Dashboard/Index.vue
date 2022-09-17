<template>
    <AppLayout title="Dashboard" :with-left-side="true">
        <template #leftside>
            <div class="py-6 pl-4 pr-6 sm:pl-6 lg:pl-8 xl:pl-0">
                <div class="flex items-center justify-between">
                    <div class="flex-1 space-y-8">
                        <div class="space-y-8 sm:flex sm:items-center sm:justify-between sm:space-y-0 xl:block xl:space-y-8">
                            <!-- Profile -->
                            <div class="flex items-center space-x-3">
                                <div class="h-12 w-12 flex-shrink-0">
                                    <Avatar
                                        class="h-12 w-12 rounded-full"
                                        :size="40"
                                        :name="$page.props.auth.account.name"
                                        variant="marble"
                                    />
                                </div>
                                <div class="space-y-1">
                                    <div class="text-sm font-medium text-gray-900">{{ $page.props.auth.account.name }}</div>
                                    <a href="#" class="group flex items-center space-x-2.5">
                                        <span class="text-sm font-medium text-gray-500 group-hover:text-gray-900">{{ $page.props.auth.account.url }}</span>
                                    </a>
                                </div>
                            </div>
                            <!-- Action buttons -->
                            <div class="flex flex-col sm:flex-row xl:flex-col">
                                <button type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 xl:w-full">New Project</button>
                                <button type="button" class="mt-3 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 xl:ml-0 xl:mt-3 xl:w-full">Invite Team</button>
                            </div>
                        </div>
                        <!-- Meta info -->
                        <div class="flex flex-col space-y-6 sm:flex-row sm:space-y-0 sm:space-x-8 xl:flex-col xl:space-x-0 xl:space-y-6">
                            <div class="flex items-center space-x-2">
                                <CheckBadgeIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                                <span class="text-sm font-medium text-gray-500">Pro Member</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <RectangleStackIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                                <span class="text-sm font-medium text-gray-500">8 Projects</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template #rightside>
            <div class="pl-6 lg:w-80">
                <div class="pt-6 pb-2">
                    <h2 class="text-sm font-semibold">Activity</h2>
                </div>
                <div>
                    <ul role="list" class="divide-y divide-gray-200">
                        <li v-for="item in activityItems" :key="item.commit" class="py-4">
                            <div class="flex space-x-3">
                                <img class="h-6 w-6 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=256&h=256&q=80" alt=""/>
                                <div class="flex-1 space-y-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium">You</h3>
                                        <p class="text-sm text-gray-500">{{ item.time }}</p>
                                    </div>
                                    <p class="text-sm text-gray-500">Deployed {{ item.project }} ({{ item.commit }} in master) to {{ item.environment }}</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="border-t border-gray-200 py-4 text-sm">
                        <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-900">
                            View all activity
                            <span aria-hidden="true"> &rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </template>

        <!-- Projects List -->
        <div class="bg-white lg:min-w-0 lg:flex-1">
            <div class="border-b border-t border-gray-200 pl-4 pr-6 pt-4 pb-4 sm:pl-6 lg:pl-8 xl:border-t-0 xl:pl-6 xl:pt-6">
                <div class="flex items-center">
                    <h1 class="flex-1 text-lg font-medium">Projects</h1>
                    <Menu as="div" class="relative">
                        <MenuButton class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <BarsArrowUpIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true"/>
                            Sort
                            <ChevronDownIcon class="ml-2.5 -mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true"/>
                        </MenuButton>
                        <MenuItems class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="py-1">
                                <MenuItem v-slot="{ active }">
                                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Name</a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Date modified</a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Date created</a>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </Menu>
                </div>
            </div>
            <ul role="list" class="divide-y divide-gray-200 border-b border-gray-200">
                <Project
                    v-for="project in projects"
                    :key="project.sid"
                    :project="project"
                    @toggle="togglePinned(project)"
                >
                </Project>
            </ul>
        </div>

    </AppLayout>

    <div class="z-0 fixed top-0 left-0 h-full w-1/2 bg-white" aria-hidden="true"/>
    <div class="z-0 fixed top-0 right-0 h-full w-1/2 bg-gray-50" aria-hidden="true"/>
</template>

<script setup>
import {computed} from "vue";
import {Inertia} from "@inertiajs/inertia";
import {Head, Link} from "@inertiajs/inertia-vue3";
import {Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import {
    BarsArrowUpIcon,
    CheckBadgeIcon,
    ChevronDownIcon,
    ChevronRightIcon,
    RectangleStackIcon,
    StarIcon,
} from '@heroicons/vue/20/solid'
import {BookmarkIcon, BookmarkSlashIcon} from '@heroicons/vue/24/outline'
import Avatar from "vue-boring-avatars";
import spacetime from 'spacetime'

import AppLayout from '@/Layouts/AppLayout.vue';
import BookmarkedProject from "./Components/BookmarkedProject.vue";
import Project from "./Components/Project.vue";

const props = defineProps({
    projects: Array
})

const pinnedProjects = computed(() => props.projects.filter((project) => project.pinned))

const togglePinned = (project) => {
    Inertia.patch(route('projects.update', project.sid), {
        pinned: !project.pinned
    }, {
        only: ['projects']
    })
}

const activityItems = []

</script>
