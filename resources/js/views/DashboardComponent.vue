<template>
  <div>
      <ProjectList 
        :taskCreateUrl="taskCreateUrl"
      />
  </div>
</template>

<script>
import ProjectList from './Project/ProjectList.vue';

export default {
  name: 'DashboardComponent',
  
    components: {
        ProjectList,
    },

    props: {
        taskCreateUrl: {
            type: String,
            default: ''
        },
    },
};
</script>