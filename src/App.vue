<script setup>
import { RouterView } from 'vue-router'
import EventsCalendar from '@/EventsCalendar.vue'

const { __, _x, _n, _nx } = wp.i18n
const plugins = ecn_vue.available_plugins
</script>

<template>
  <header>
    <div class="wrapper">
      <div class="grid grid-cols-2">
        <div class="font-bold">
          {{ __('Events Calendar:', 'event-calendar-newsletter') }}
        </div>
        <EventsCalendar :availablePlugins="plugins" />
      </div>
    </div>
  </header>

  <RouterView />
</template>
