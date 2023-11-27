import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp, Link } from '@inertiajs/vue3'
import  MainLayout  from "./Layouts/MainLayout.vue";

import { ZiggyVue } from 'ziggy';
import { Ziggy } from './ziggy';


createInertiaApp({
  resolve: (name) => {
    let page = require(`./Pages/${name}.vue`).default
    page.layout ??= MainLayout
    /*if (page.layout == null) {
      page.layout = MainLayout
    }*/

    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .component("Link", Link) 
      .mixin({ methods: { route } })
      .mount(el)
  },
})