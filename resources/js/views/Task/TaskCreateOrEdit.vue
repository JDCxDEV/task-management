<template>
    <template v-if="!iconClass">
        <button :class="isEditing ? 'btn btn-primary' : 'btn btn-success'" @click="openTaskModal">
            {{ !isEditing ? 'Create' : 'Edit' }} Task
        </button>
    </template>

    <template v-else>
        <button :class="isEditing ? 'btn btn-primary' : 'btn btn-success'" @click="openTaskModal">
            <i :class="iconClass"></i>
        </button>
    </template>

    <Modal :id="modalId" :title="!isEditing ? 'Create new task' : 'Edit Task'" ref="taskForm" @save="submitTask">
        <form>
            <div class="mb-3">
                <label for="taskName" class="form-label">Task Name</label>
                <input type="text" class="form-control" id="taskName" v-model="taskName" required>
            </div>
        </form>
    </Modal>
</template>

<script>
import { ref, inject } from 'vue';
import axios from 'axios';
import Modal from '../../components/Modal.vue'; // Adjust the path as needed

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
            default: null
        },
        taskId: {
            type: String,
            default: null
        },
        modalId: {
            type: String,
            default: 'taskModal'
        },
        class: {
            type: String,
            default: ''
        },
    },

    setup(props) {
        const taskName = ref('');
        const emitter = inject('emitter');

        let updateUrl = ref('');
        let taskForm = ref(null);

        const openTaskModal = async () => {
            taskForm.value.openModal();

            if (props.isEditing) {
                await getTask(props.viewUrl);
            }
        };

        const closeTaskModal = () => {
            taskForm.value.closeModal();
        };

        const getTask = async (viewUrl) => {
            if (viewUrl) {
                const response = await axios.get(viewUrl); // Assuming it's a GET request for viewUrl
                taskName.value = response.data.name;
                updateUrl.value = response.data.updateUrl;
            }
        };

        const submitTask = async () => {
            try {
                if (props.isEditing) {
                    await axios.put(updateUrl.value, { name: taskName.value });
                    await emitter.emit('task-create-or-update', props.taskId);
                } else {
                    await axios.post(props.createUrl, { name: taskName.value });
                    await emitter.emit('task-create-or-update');
                }

                closeTaskModal();
            } catch (error) {
                console.error('Error:', error);
            }
        };

        return {
            taskForm,
            taskName,
            openTaskModal,
            closeTaskModal,
            submitTask
        };
    }
};
</script>