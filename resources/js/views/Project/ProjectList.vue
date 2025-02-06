<template>
  <div>
    <div class="mb-4" v-if="projects.length">
		<div class="row">
			<div class="col-9">
				<select v-model="selectedTask" class="form-select" >
					<option v-for="project in projects" :key="project.id" :value="project.id">
					{{ project.name }}
					</option>
				</select>
			</div>
			<div class="col-3">
				<button class="btn btn btn-light">
          <i class="fas fa-cog"></i>
        </button>

				<button class="btn btn-success float-end">
          Add New Task
        </button>
			</div>
		</div>
    </div>
    <TaskListComponent :projectId="selectedTask"></TaskListComponent>
  </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

import TaskListComponent from '../Task/TaskList.vue';

export default {
  name: 'ProjectList',

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
        selectedTask.value = projects.value ? projects.value[0].id : null;

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