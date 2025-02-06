<template>
  <div>
    <button :class="isEditing ? 'btn btn-primary' : 'btn btn-success'" @click="openModal">{{ !isEditing ? 'Create' : 'Edit' }} Project</button>

    <Modal :id="modalId" title="Create new project" ref="projectForm" @save="submit">
        <form>
            <div class="mb-3">
                <label for="projectName" class="form-label">Project Name</label>
                <input type="text" class="form-control" id="projectName" v-model="projectName" required>
            </div>
        </form>
    </Modal >
  </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

import Modal from '../../components/modal.vue';

export default {
    components: {
        Modal
    },

    props: {
        createUrl: {
            type: String,
            default: false
        },
        updateUrl: {
            type: String,
            default: false
        },
        isEditing: {
            type: Boolean,
            default: false
        },
        modalId: {
            type: String,
            default: 'projectModal'
        }
    },

    setup(props) {

        const projectName = ref('');
        let projectForm = ref(null);

        const closeModal = () => {
            projectForm.value.closeModal();
        };

        const submit = async () => {
            try {
                if (props.isEditing) {
                    await axios.put(`/api/projects/${props.projectId}`, { projectName: projectName.value });
                } else {
                    await axios.post(props.createUrl, { name: projectName.value });
                }
                closeModal();
            } catch (error) {
                console.error('Error:', error);
            }
        };

        const openModal =  () => {
            projectForm.value.openModal();
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

<style scoped>
/* Optional: Add custom styles here */
</style>
