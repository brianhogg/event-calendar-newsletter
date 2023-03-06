<script setup>
const props = defineProps(['availablePlugins'])
</script>
<template>
  <div>
    <select name="event_calendar">
      <option v-for="(name, slug) in props.availablePlugins" :value="slug">{{ name }}</option>
    </select>
  </div>
</template>
