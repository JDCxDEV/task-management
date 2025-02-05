<template>
  <div>
    <div class="mb-4" v-if="projects.length">
        <select v-model="selectedTask" class="form-select" >
        <option v-for="project in projects" :key="project.id" :value="project.id">
          {{ project.name }}
        </option>
      </select>
    </div>
        <TaskListComponent :projectId="selectedTask"></TaskListComponent>
  </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import TaskListComponent from './TaskListComponent.vue';

export default {
  name: 'ProjectComponent',

  components: {
    TaskListComponent,
  },
  setup() {
    const projects = ref([]);
    const selectedTask = ref(null);

    const fetchProject = async () => {
      try {
        const response = await axios.get(`/projects/`);
        projects.value = response.data.projects;
        selectedTask.value = projects.value[0].id;
      } catch (error) {
        console.error('Error fetching project:', error);
      }
    };

    onMounted(() => {
      fetchProject();
    });

    watch(selectedTask.value, () => {
      emitSelectedTask();
    });

    return {
      projects,
      selectedTask,
    };
  },
};
</script>