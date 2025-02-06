<template>
  <div ref="modal" class="modal fade" :id="id" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ title }}</h5>
                <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <slot></slot>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
                <button type="button" class="btn btn-primary" @click="saveModal">Save changes</button>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { Modal } from "bootstrap";

export default {
    name: 'Modal',
    props: {
        id: {
            type: String,
            required: true
        },
        title: {
            type: String,
            default: 'Modal Title'
        }
    },

    emits: ['close', 'save'],

    setup(props, { emit }) {

        const modal = ref(null);

        const openModal = () => {
            modal.value.show();
            emit('show');
        };
        const closeModal = () => {
            modal.value.hide();
            emit('close');
        };

        const saveModal = () => {
            emit('save');
            closeModal();
        };

        onMounted(() => {
            modal.value = new Modal(`#${props.id}`, {})
        });


        return {
            closeModal,
            saveModal,
            openModal
        };
        
    }
};
</script>

<style scoped>
/* Optional: Add your custom styles here */
</style>
