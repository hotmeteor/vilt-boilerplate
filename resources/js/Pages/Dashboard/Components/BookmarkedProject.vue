<template>
  <li class="relative col-span-1 flex rounded-md shadow-sm">
    <div
      :class="[
        'flex w-16 flex-shrink-0 items-center justify-center rounded-l-md text-sm font-medium text-white',
      ]"
      :style="`background-color: ${project.color}`"
      >{{ project.initials }}
    </div>
    <div
      class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white"
    >
      <div class="flex-1 truncate px-4 py-2 text-sm">
        <a class="font-medium text-gray-900 hover:text-gray-600" href="#">{{ project.name }}</a>
        <p class="text-gray-500">{{ project.components_count }} components</p>
      </div>
      <Menu as="div" class="flex-shrink-0 pr-2">
        <MenuButton
          class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
        >
          <span class="sr-only">Open options</span>
          <EllipsisVerticalIcon aria-hidden="true" class="h-5 w-5" />
        </MenuButton>
        <transition
          enter-active-class="transition ease-out duration-100"
          enter-from-class="transform opacity-0 scale-95"
          enter-to-class="transform opacity-100 scale-100"
          leave-active-class="transition ease-in duration-75"
          leave-from-class="transform opacity-100 scale-100"
          leave-to-class="transform opacity-0 scale-95"
        >
          <MenuItems
            class="absolute right-10 top-3 z-10 mx-3 mt-1 w-48 origin-top-right divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
          >
            <div class="py-1">
              <MenuItem v-slot="{ active }">
                <a
                  :class="[
                    active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                    'block px-4 py-2 text-sm',
                  ]"
                  href="#"
                  >View</a
                >
              </MenuItem>
            </div>
            <div class="py-1">
              <MenuItem v-slot="{ active }">
                <button
                  :class="[
                    active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                    'block w-full px-4 py-2 text-left text-sm',
                  ]"
                  @click="$emit('unpin')"
                  >Remove bookmark
                </button>
              </MenuItem>
              <MenuItem v-slot="{ active }">
                <a
                  :class="[
                    active ? 'bg-gray-100 text-gray-900' : 'text-gray-700',
                    'block px-4 py-2 text-sm',
                  ]"
                  href="#"
                  >Share</a
                >
              </MenuItem>
            </div>
          </MenuItems>
        </transition>
      </Menu>
    </div>
  </li>
</template>

<script setup>
  import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
  import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid'

  defineProps({
    project: Object,
  })

  defineEmits(['unpin'])
</script>
