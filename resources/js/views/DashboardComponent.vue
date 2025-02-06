<template>
  <div>
      <ProjectList></ProjectList>
  </div>
</template>

<script>
import ProjectList from './Project/ProjectList.vue';

export default {
  name: 'DashboardComponent',
  
  components: {
    ProjectList,
  },
};
</script>