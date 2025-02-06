<template>
    <template v-if="!iconClass">
            <button :class="isEditing ? 'btn btn-primary' : 'btn btn-success'" @click="openModal">
            {{ !isEditing ? 'Create' : 'Edit' }} Project
            </button>
    </template>

    <template v-else>
        <button :class="isEditing ? 'btn btn-primary' : 'btn btn-success'" @click="openModal">
            <i :class="iconClass"></i>
        </button>
    </template>

    <Modal :id="modalId" :title="!isEditing ? 'Create new project' : 'Edit Project'" ref="projectForm" @save="submit">
        <form>
            <div class="mb-3">
                <label for="projectName" class="form-label">Project Name</label>
                <input type="text" class="form-control" id="projectName" v-model="projectName" required>
            </div>
        </form>
    </Modal>
</template>

<script>
import { ref, inject } from 'vue';
import axios from 'axios';

import Modal from '../../components/modal.vue';

export default {
    components: {
        Modal
    },

    props: {
        viewUrl: {
            type: String,
            default: ''
        },
        createUrl: {
            type: String,
            default: ''
        },
        isEditing: {
            type: Boolean,
            default: false
        },
        iconClass: {
            type: String,
            default: null,
        },
        projectId: {
            type: String,
            default: null
        },
        modalId: {
            type: String,
            default: 'projectModal'
        },
    },

    setup(props) {

        const projectName = ref('');
        const emitter = inject('emitter');

        let updateUrl = ref('')
        let projectForm = ref(null);

        const openModal =  async () => {
            projectForm.value.openModal();

            if (props.isEditing) {
                await getProject(props.viewUrl);
            }
        };

        const closeModal = () => {
            projectForm.value.closeModal();
        };

        const getProject = async (viewUrl) => {

            if (viewUrl) {
                const response = await axios.post(viewUrl);
                projectName.value = response.data.name;
                updateUrl.value = response.data.updateUrl;
            }
 
        }

        const submit = async () => {
            try {
                if (props.isEditing) {
                    await axios.put(updateUrl.value, { name: projectName.value });
                    await emitter.emit('project-create-or-update', props.projectId);
                } else {
                    await axios.post(props.createUrl, { name: projectName.value });
                    await emitter.emit('project-create-or-update');
                }

                closeModal();
  
            } catch (error) {
                console.error('Error:', error);
            }
        };

        return {
            projectForm,
            projectName,
            openModal,
            closeModal,    
            submit
        };
    }
};
</script>
