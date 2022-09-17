<template>
    <li class="relative py-5 pl-4 pr-6 hover:bg-gray-50 sm:py-6 sm:pl-6 lg:pl-8 xl:pl-6">
        <div class="flex items-center justify-between space-x-4">
            <!-- Repo name and link -->
            <div class="min-w-0 space-y-3">
                <div class="flex items-center space-x-3">
                    <span :class="[project.active ? 'bg-green-100' : 'bg-gray-100', 'h-4 w-4 rounded-full flex items-center justify-center']" aria-hidden="true">
                        <span :class="[project.active ? 'bg-green-400' : 'bg-gray-400', 'h-2 w-2 rounded-full']"/>
                    </span>

                    <h2 class="text-sm font-medium">
                        <Link :href="route('projects.show', [project.sid, project.slug])">
                            <span class="absolute inset-0" aria-hidden="true"/>
                            {{ project.name }}
                            <span class="sr-only">{{ project.active ? 'Running' : 'Not running' }}</span>
                        </Link>
                    </h2>
                </div>
                <p class="flex space-x-2 text-sm text-gray-500">
                    <span v-text="`${project.components_count} ${project.components_count === 1 ? 'component' : 'components'}`"/>
                    <!--                    <span aria-hidden="true">&middot;</span>-->
                    <!--                    <span v-text="`${project.members_count} ${project.members_count === 1 ? 'member' : 'members'}`" />-->
                    <!--                    <span aria-hidden="true">&middot;</span>-->
                    <!--                    <span>{{ project.location }}</span>-->
                </p>
            </div>
            <div class="sm:hidden">
                <ChevronRightIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
            </div>
            <!-- Repo meta info -->
            <div class="hidden flex-shrink-0 flex-col items-end space-y-3 sm:flex">
                <p class="flex items-center space-x-4">
<!--                    <button @click="$emit('toggle')" type="button" class="relative focus:outline-none">-->
<!--                        <span class="sr-only">{{ project.starred ? 'Add to favorites' : 'Remove from favorites' }}</span>-->
<!--                        <BookmarkIcon :class="[project.pinned ? 'text-yellow-300 hover:text-yellow-400' : 'text-gray-300 hover:text-gray-400', 'h-5 w-5']" aria-hidden="true"/>-->
<!--                    </button>-->
                </p>
                <div class="flex items-center space-x-2">
                    <div class="isolate flex -space-x-1 overflow-hidden">
                        <Avatar
                            v-for="member in project.members"
                            :key="member.id"
                            class="h-6 w-6 max-w-none rounded-full ring-2 ring-white"
                            :size="40"
                            :name="member.name"
                            variant="marble"
                        />
                    </div>
                    <span v-if="project.totalMembers > project.members.length" class="flex-shrink-0 text-xs font-medium leading-5">+{{ project.totalMembers - project.members.length }}</span>
                </div>
            </div>
        </div>
    </li>
</template>

<script setup>
import {Link} from "@inertiajs/inertia-vue3";
import {BookmarkIcon, ChevronRightIcon,} from '@heroicons/vue/20/solid'
import Avatar from "vue-boring-avatars";

defineProps({
    project: Object
})

defineEmits(['toggle'])

</script>
