<script setup>
import { RouterView } from 'vue-router'
import EventsCalendar from '@/EventsCalendar.vue'

const { __, _x, _n, _nx } = wp.i18n
</script>

<template>
  <header>
    <div class="wrapper">
      <div class="text-3xl italic text-red-400">
        {{ __('Events Calendar:', 'event-calendar-newsletter') }}
      </div>
      <EventsCalendar />
    </div>
  </header>

  <RouterView />
</template>
