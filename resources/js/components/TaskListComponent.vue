<template>
  <div>
    <draggable 
      @start="drag=true" 
      @end="handleDragEnd"
      v-model="tasks" 
      tag="div" 
      class="task-list"
      >
      <template #item="{ element }">
        <div class="task-item">
          <div>{{ element.name }}</div>
          <div>Priority: {{ element.priority }}</div>
        </div>
      </template>
    </draggable>
  </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import draggable from 'vuedraggable';

export default {
  name: 'TaskListComponent',
  props: {
    projectId: {
      type: Number,
      required: true,
    },
  },
  components: {
    draggable,
  },
  setup(props) {
    const tasks = ref([]);
       const drag = ref(false);

    const fetchTasks = async () => {
      if (props.projectId) {
        try {
          const response = await axios.get(`/projects/${props.projectId}/tasks`);
          tasks.value = response.data.tasks;
        } catch (error) {
          console.error('Error fetching tasks:', error);
        }
      }
    };

    const handleDragEnd = async () => {
      // Logic to update task order after drag and drop
      try {
        // Assuming you have an API endpoint to update task order
        const response = await axios.put(`/projects/${props.projectId}/tasks/order`, { tasks: tasks.value });
        if (!response.ok) {
          throw new Error('Failed to update task order');
        }
      } catch (error) {
        console.error('Error updating task order:', error);
      }
    };

    onMounted(fetchTasks);
    watch(() => props.projectId, fetchTasks);

    return {
      tasks,
      drag,
      handleDragEnd,
    };
  },
};
</script>

<style scoped>
.task-list {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.task-item {
  background-color: #f0f0f0;
  padding: 10px;
  margin-bottom: 5px;
  border: 1px solid #ddd;
  border-radius: 3px;
}
</style>
