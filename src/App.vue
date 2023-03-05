<script setup>
import { RouterView } from 'vue-router'
const { __, _x, _n, _nx } = wp.i18n
</script>

<template>
  <header>
    <div class="wrapper">
      <div class="text-3xl italic text-red-400">
        {{ __('Events Calendar:', 'event-calendar-newsletter') }}
      </div>
      <div>
        <select name="event_calendar">
          <option value="the-events-calendar">The Events Calendar</option>
        </select>
      </div>
    </div>
  </header>

  <RouterView />
</template>

<style scoped></style>
