<template>
  <div>
    <table class="table task-table">
      <thead>
        <tr>
          <th scope="col">Task Name</th>
          <th scope="col">Priority</th>
        </tr>
      </thead>
        <draggable
          @start="drag = true"
          @end="reArrangeTaskOrder"
          v-model="tasks"
          tag="tbody"
          :element="'tr'"
          :options="{ animation: 150 }"
        >
          <template #item="{ element, index }">
            <tr class="task-item ">
              <td>{{ element.name }}</td>
              <td>{{ index + 1 }}</td>
            </tr>
          </template>
        </draggable>
    </table>
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

    const reArrangeTaskOrder = async () => {
      try {
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
      reArrangeTaskOrder,
    };
  },
};
</script>

<style scoped>
.task-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.task-table th,
.task-table td {
  padding: 10px;
  text-align: left;
  border: 1px solid #ddd;
}

.task-table th {
  background-color: #f0f0f0;
}

.task-item {
  cursor: move;
}
</style>
