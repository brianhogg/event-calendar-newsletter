<script setup>
import { RouterView } from 'vue-router'
</script>

<template>
  <header>
    <div class="wrapper">
      <select name="event_calendar">
        <option value="the-events-calendar">The Events Calendar</option>
      </select>
    </div>
  </header>

  <RouterView />
</template>

<style scoped></style>
