<template>
  <Combobox as="div" v-model="selectedOption">
    <ComboboxLabel v-if="label" class="block text-sm font-medium text-gray-700">{{
      label
    }}</ComboboxLabel>
    <div :class="['relative', label ? 'mt-1' : '']">
      <ComboboxInput
        class="w-full border-0 bg-white py-2 pl-3 pr-10 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:text-sm"
        @change="query = $event.target.value"
        :display-value="(option) => option?.label"
      />
      <ComboboxButton
        class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none"
      >
        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
      </ComboboxButton>

      <ComboboxOptions
        v-if="filteredOptions.length > 0"
        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
      >
        <ComboboxOption
          v-for="option in filteredOptions"
          :key="option.value"
          :value="option"
          as="template"
          v-slot="{ active, selected }"
        >
          <li
            :class="[
              'relative cursor-default select-none py-2 pl-3 pr-9',
              active ? 'bg-indigo-600 text-white' : 'text-gray-900',
            ]"
          >
            <div class="flex items-center">
              <span
                :class="[
                  'inline-block h-2 w-2 flex-shrink-0 rounded-full',
                  option.color ? `bg-[${option.color}]` : 'bg-gray-200',
                ]"
                aria-hidden="true"
              />
              <span :class="['ml-3 truncate', selected && 'font-semibold']">
                {{ option.label }}
                <!--                <span class="sr-only"> is {{ person.online ? 'online' : 'offline' }}</span>-->
              </span>
            </div>
            <span
              v-if="selected"
              :class="[
                'absolute inset-y-0 right-0 flex items-center pr-4',
                active ? 'text-white' : 'text-indigo-600',
              ]"
            >
              <CheckIcon class="h-5 w-5" aria-hidden="true" />
            </span>
          </li>
        </ComboboxOption>
      </ComboboxOptions>
    </div>
  </Combobox>
</template>

<script setup>
  import { computed, ref } from 'vue'
  import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
  import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxLabel,
    ComboboxOption,
    ComboboxOptions,
  } from '@headlessui/vue'

  const props = defineProps({
    options: {
      type: Array,
      required: true,
    },
    selectedOption: {
      type: String,
      required: false,
    },
    label: {
      type: String,
      required: false,
    },
  })

  const query = ref('')
  const filteredOptions = computed(() =>
    query.value === ''
      ? props.options
      : props.options.filter((option) => {
          return option.label.toLowerCase().includes(query.value.toLowerCase())
        }),
  )
</script>
