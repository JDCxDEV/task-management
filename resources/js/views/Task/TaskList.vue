<template>
  <div>
    <table class="table task-table">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Task Name</th>
				<th scope="col">Action</th>
			</tr>
		</thead>
        <draggable
          @start="drag = true"
          @end="reArrangeTaskOrder"
          v-model="tasks"
          tag="tbody"
          :element="'tr'"
          :options="{ animation: 150 }"
		  itemKey="id"
        >
			<template #item="{ element, index }">
				<tr class="task-item" >
					<td class="text-center">
						{{ index + 1 }}
					</td>
					<td>{{ element.name }}</td>
					<td class="text-center">
						<button class="btn btn-warning m-1 text-white">
							<i class="fa-solid fa-pen-to-square"></i>
						</button>
						<button class="btn btn-danger">
							<i class="fa-solid fa-trash"></i>
						</button>
					</td>
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
	name: 'TaskList',

	props: {
		projectId: {
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
			await axios.put(`/projects/${props.projectId}/tasks/order`, { tasks: tasks.value });
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
  border-radius: 20px;
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
