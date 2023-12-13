import '../css/app.css'
import './bootstrap'

import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createApp, h } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'

const appName = import.meta.env.VITE_APP_NAME
const appUrl = import.meta.env.VITE_APP_URL

createInertiaApp({
  title: (title) => `${title}`,
  resolve: (name) =>
    resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .provide('appName', appName)
      .provide('appUrl', appUrl)
      .mount(el)
  },
  progress: false,
})
