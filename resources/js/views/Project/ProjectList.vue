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
                <div class="row">
                    <div class="col-4">
                        <ProjectCreateOrEdit 
                            modalId="projectUpdate" 
                            :isEditing="true" 
                            :projectId="projectId" 
                            :viewUrl="project.viewUrl ? project.viewUrl : '' " 
                            iconClass="fas fa-cog"
                        />
                    </div>
                    <div class="col-8">      
                        <TaskCreateOrEdit 
                            modalId="taskCreate" 
                            :projectId="projectId"
                        />
                    </div>
                </div>
			</div>
		</div>
    </div>
    <TaskList :projectId="projectId"></TaskList>
</div>
</template>

<script>
import { inject, ref, onMounted, watch } from 'vue';
import axios from 'axios';

import ProjectCreateOrEdit from '../Project/ProjectCreateOrEdit.vue';
import TaskCreateOrEdit from '../Task/TaskCreateOrEdit.vue'; 
import TaskList from '../Task/TaskList.vue';

export default {
  name: 'ProjectList',

    components: {
        TaskList,
        ProjectCreateOrEdit,
        TaskCreateOrEdit
    },
  
    setup() {
        const projectId = ref('');
        const project = ref({});
        const projects = ref([]);

        const emitter = inject('emitter');

        emitter.on('project-create-or-update', async (value) => {  
            if (value) {
                await fetchProject(value);
            } else {
                await fetchProject();
            }
        });
        

        const fetchProject = async (value = null) => {
            try {
                const response = await axios.get(`/projects/`);
                projects.value = response.data.projects;

                if (value == null) {
                    projectId.value = projects.value ? projects.value[0].id : '';
                } else {
                    projectId.value = value;
                }

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
            projectId,
            project,
            projects,
        };
    },
};
</script>