<script setup>
const props = defineProps(['taco'])
</script>
<template>
  <div>
    <select name="event_calendar">
      <option v-for="(name, slug) in props.taco" :value="slug">{{ name }}</option>
    </select>
  </div>
</template>
