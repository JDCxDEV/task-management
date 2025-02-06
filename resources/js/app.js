import { createApp } from "vue";
import DashboardComponent from "./views/DashboardComponent.vue";
import ProjectCreateOrDelete from "./views/Project/ProjectCreateOrEdit.vue";

const app = createApp({});

app.component("dashboard", DashboardComponent);
app.component("project-create-or-delete", ProjectCreateOrDelete);

app.mount("#app");
