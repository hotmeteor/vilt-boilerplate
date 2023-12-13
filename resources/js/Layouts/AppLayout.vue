<template>
  <Head :title="title" />
  <Banner />

  <div class="relative z-10 flex min-h-full flex-col">
    <!-- Navbar -->
    <Disclosure as="nav" class="flex-shrink-0 bg-indigo-600" v-slot="{ open }">
      <div class="mx-auto w-full max-w-7xl px-2 sm:px-8 lg:px-10">
        <div class="relative flex h-16 items-center justify-between">
          <!-- Logo section -->
          <div class="flex items-center px-2 lg:px-0 xl:w-64">
            <Link :href="route('dashboard')" class="flex-shrink-0">
              <img
                class="h-8 w-auto"
                src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=300"
                alt="Your Company"
              />
            </Link>
          </div>

          <!-- Search section -->
          <div class="flex flex-1 justify-center lg:justify-end">
            <div class="w-full px-2 lg:px-6">
              <label for="search" class="sr-only">Search projects</label>
              <div class="relative text-indigo-200 focus-within:text-gray-400">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                  <MagnifyingGlassIcon class="h-5 w-5" aria-hidden="true" />
                </div>
                <input
                  id="search"
                  name="search"
                  class="block w-full rounded-md border border-transparent bg-indigo-400 bg-opacity-25 py-2 pl-10 pr-3 leading-5 text-indigo-100 placeholder-indigo-200 focus:bg-white focus:text-gray-900 focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-sm"
                  placeholder="Search projects"
                  type="search"
                />
              </div>
            </div>
          </div>

          <div class="flex lg:hidden">
            <!-- Mobile menu button -->
            <DisclosureButton
              class="inline-flex items-center justify-center rounded-md bg-indigo-600 p-2 text-indigo-400 hover:bg-indigo-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600"
            >
              <span class="sr-only">Open main menu</span>
              <Bars3CenterLeftIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
              <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
            </DisclosureButton>
          </div>

          <!-- Links section -->
          <div class="hidden lg:block lg:w-80">
            <div class="flex items-center justify-end">
              <div class="flex">
                <Link
                  v-for="item in navigation"
                  :key="item.label"
                  :href="route(item.route)"
                  class="rounded-md px-3 py-2 text-sm font-medium text-indigo-200 hover:text-white"
                  :aria-current="route().current(item.route) ? 'page' : undefined"
                >
                  {{ item.label }}
                </Link>
              </div>
              <!-- Profile dropdown -->
              <Menu as="div" class="relative ml-4 flex-shrink-0">
                <div>
                  <MenuButton
                    class="flex rounded-full bg-indigo-700 text-sm text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-700"
                  >
                    <span class="sr-only">Open user menu</span>
                    <img
                      class="h-8 w-8 rounded-full"
                      :src="$page.props.auth.user.profile_photo_url"
                      alt=""
                    />
                  </MenuButton>
                </div>
                <transition
                  enter-active-class="transition ease-out duration-100"
                  enter-from-class="transform opacity-0 scale-95"
                  enter-to-class="transform opacity-100 scale-100"
                  leave-active-class="transition ease-in duration-75"
                  leave-from-class="transform opacity-100 scale-100"
                  leave-to-class="transform opacity-0 scale-95"
                >
                  <MenuItems
                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                  >
                    <MenuItem v-for="item in userNavigation" :key="item.label" v-slot="{ active }">
                      <Link
                        :href="route(item.route)"
                        :class="[
                          route().current(item.route) ? 'bg-gray-100' : '',
                          'block px-4 py-2 text-sm text-gray-700',
                        ]"
                      >
                        {{ item.label }}
                      </Link>
                    </MenuItem>
                    <MenuItem>
                      <Link
                        method="post"
                        as="button"
                        type="button"
                        href="/logout"
                        class="block w-full px-4 py-2 text-left text-sm text-gray-700"
                      >
                        Sign Out
                      </Link>
                    </MenuItem>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
          </div>
        </div>
      </div>

      <!--            <DisclosurePanel class="lg:hidden">-->
      <!--                <div class="space-y-1 px-2 pt-2 pb-3">-->
      <!--                    <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'text-white bg-indigo-800' : 'text-indigo-200 hover:text-indigo-100 hover:bg-indigo-600', 'block px-3 py-2 rounded-md text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>-->
      <!--                </div>-->
      <!--                <div class="border-t border-indigo-800 pt-4 pb-3">-->
      <!--                    <div class="space-y-1 px-2">-->
      <!--                        <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href" class="block rounded-md px-3 py-2 text-base font-medium text-indigo-200 hover:bg-indigo-600 hover:text-indigo-100">{{ item.name }}</DisclosureButton>-->
      <!--                    </div>-->
      <!--                </div>-->
      <!--            </DisclosurePanel>-->
    </Disclosure>

    <slot name="header"></slot>

    <main>
      <slot />
    </main>
  </div>
</template>

<script setup>
  import { Head, Link, router } from '@inertiajs/vue3'
  import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
  } from '@headlessui/vue'
  import {
    BarsArrowUpIcon,
    CheckBadgeIcon,
    ChevronDownIcon,
    ChevronRightIcon,
    MagnifyingGlassIcon,
    RectangleStackIcon,
    StarIcon,
  } from '@heroicons/vue/20/solid'
  import { Bars3CenterLeftIcon, XMarkIcon } from '@heroicons/vue/24/outline'
  import Avatar from 'vue-boring-avatars'
  import Banner from '@/Components/Banner.vue'

  const navigation = [
    { label: 'Dashboard', route: 'dashboard' },
    // { name: 'Domains', href: '#', current: false },
  ]

  const userNavigation = [
    { label: 'Your Profile', route: 'profile.show' },
    // {label: 'Settings', route: '#'},
    // {label: 'Sign out', route: '#', form: true},
  ]

  const activityItems = [
    { project: 'Workcation', commit: '2d89f0c8', environment: 'production', time: '1h' },
  ]

  defineProps({
    title: String,
    withLeftSide: {
      type: Boolean,
      required: false,
      default: false,
    },
  })

  const switchToTeam = (team) => {
    router.put(
      route('current-team.update'),
      {
        team_id: team.id,
      },
      {
        preserveState: false,
      },
    )
  }

  const logout = () => {
    router.post(route('logout'))
  }
</script>
