<template>
  <div>
    <button v-if="!iconClass" :class="isEditing ? 'btn btn-primary' : 'btn btn-success'" @click="openModal">
        {{ !isEditing ? 'Create' : 'Edit' }} Project
    </button>

    <button v-else :class="isEditing ? 'btn btn-primary' : 'btn btn-success'" @click="openModal">
       <i :class="iconClass"></i>
    </button>

    <Modal :id="modalId" :title="!isEditing ? 'Create new project' : 'Edit Project'" ref="projectForm" @save="submit">
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
        let updateUrl = ref('')
        let projectForm = ref(null);

        const openModal =  () => {
            projectForm.value.openModal();

            if (props.isEditing) {
                getProject(props.viewUrl);
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
                } else {
                    await axios.post(props.createUrl, { name: projectName.value });
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

<style scoped>
/* Optional: Add custom styles here */
</style>
