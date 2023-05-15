import.meta.glob([
    '../niceadmin/img/**'
]);

import './bootstrap';

import '../niceadmin/vendor/bootstrap/css/bootstrap.css';

import '../niceadmin/vendor/bootstrap-icons/bootstrap-icons.css';
import '../niceadmin/vendor/boxicons/css/boxicons.css';
import '../niceadmin/vendor/remixicon/remixicon.css';

import '../niceadmin/css/style.css';
import '../css/app.css';

import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import {createApp} from 'vue'

import App from './pages/blogs.vue'

createApp(App).mount("#app")