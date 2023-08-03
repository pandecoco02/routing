import './bootstrap';
import router from './routes'
import store from '@/store'
import vuetify from "../plugins/vuetify";
import axios from 'axios';
import "../assets/scss/style.scss";

axios.defaults.baseURL = 'http://localhost:8000/api/';
axios.defaults.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`;

import { createApp } from 'vue/dist/vue.esm-bundler';

const app = createApp({})
app.use(vuetify)
app.use(router)
app.use(store)
app.mount('#app')