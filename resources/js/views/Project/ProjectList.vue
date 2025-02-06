<template>
  <div>
    <div class="mb-4" v-if="projects.length">
		<div class="row">
			<div class="col-9">
				<select v-model="projectId" class="form-select" >
					<option v-for="project in projects" :key="project.id" :value="project.id">
					{{ project.name }}
					</option>
				</select>
			</div>
			<div class="col-3">
                <ProjectCreateOrEdit modalId="projectUpdate" :isEditing="true" :projectId="projectId" :viewUrl="project.viewUrl ? project.viewUrl : '' " iconClass="fas fa-cog"></ProjectCreateOrEdit>

				<button class="btn btn-success float-end">
                    Add New Task
                </button>
			</div>
		</div>
    </div>
    <TaskListComponent :projectId="projectId"></TaskListComponent>
  </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

import ProjectCreateOrEdit from '../Project/ProjectCreateOrEdit.vue';
import TaskListComponent from '../Task/TaskList.vue';

export default {
  name: 'ProjectList',

    components: {
        ProjectCreateOrEdit,
        TaskListComponent,
    },
  
    setup() {
        const projects = ref([]);
        const projectId = ref(null);
        const project = ref({});

        const fetchProject = async () => {
            try {
                const response = await axios.get(`/projects/`);
                projects.value = response.data.projects;
                projectId.value = projects.value ? projects.value[0].id : null;

            } catch (error) {
                console.error('Error fetching project:', error);
            }
        };

        const findProjectById = () => {
            const result = projects.value.find(proj => proj.id === projectId.value);

            if (project) {
                project.value = result;
            }
        };

        onMounted(() => {
            fetchProject();
        });

        watch(() => projectId.value, () => {
            findProjectById();
        });

        return {
            projects,
            project,
            projectId,
        };
    },
};
</script>