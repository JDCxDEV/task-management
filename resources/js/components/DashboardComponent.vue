<template>
  <div>
      <ProjectComponent></ProjectComponent>
  </div>
</template>

<script>
import ProjectComponent from './ProjectListComponent.vue';

export default {
  name: 'DashboardComponent',
  
  components: {
    ProjectComponent,
  },
};
</script>