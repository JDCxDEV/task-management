import { createApp } from "vue";
import mitt from "mitt";
import DashboardComponent from "./views/DashboardComponent.vue";
import ProjectCreateOrDelete from "./views/Project/ProjectCreateOrEdit.vue";

const emitter = mitt();   
const app = createApp({});

app.provide("emitter", emitter);

app.component("dashboard", DashboardComponent);
app.component("project-create-or-delete", ProjectCreateOrDelete);

app.mount("#app");
