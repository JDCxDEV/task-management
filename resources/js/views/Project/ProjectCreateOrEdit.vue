<template>
  <div>
    <button :class="isEditing ? 'btn btn-primary' : 'btn btn-success'" @click="openModal">{{ !isEditing ? 'Create' : 'Edit' }} Project</button>

    <Modal :id="modalId" title="Create new project" ref="projectForm">
        <form @submit.prevent="handleSubmit">
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
import Modal from '../../components/modal.vue';

export default {
    components: {
        Modal
    },

    props: {
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
            showModal.value = false;
        };

        const handleSubmit = () => {
            if (props.isEditing) {
                console.log('Editing project name:', projectName.value);
            } else {
                console.log('Creating project with name:', projectName.value);
            }
            closeModal();
        };

        const openModal =  () => {
            projectForm.value.openModal();
        };
    

        return {
            openModal,
            projectName,
            closeModal,
            handleSubmit,
            projectForm
        };
    }
};
</script>

<style scoped>
/* Optional: Add custom styles here */
</style>
