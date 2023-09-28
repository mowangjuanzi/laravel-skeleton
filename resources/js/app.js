// import '../css/app.css';
import {createApp} from "vue";

import App from "../pages/app.vue";
import router from "../routes/index.js";

const app = createApp(App);

app.use(router);

app.mount('#app');
