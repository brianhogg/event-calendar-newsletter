<script setup>
import { RouterView } from 'vue-router'
import EventsCalendar from '@/EventsCalendar.vue'

const { __, _x, _n, _nx } = wp.i18n
const plugin = ecn_vue.available_plugins
</script>

<template>
  <header>
    <div class="wrapper">
      <div class="text-3xl italic text-red-400">
        {{ __('Events Calendar:', 'event-calendar-newsletter') }}
      </div>
      <EventsCalendar :availablePlugins="plugin" />
    </div>
  </header>

  <RouterView />
</template>
