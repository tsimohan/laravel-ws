import Vue from "vue";
import VueRouter from 'vue-router';

import Home from './pages/Home.vue';

import Students from './pages/students/index.vue';
// import StudentsAdd from './pages/students/add.vue';

const routes = [
    {
        path: '/',
        name: 'home',
        component: Students
    },
    {
        path: '/students',
        name: 'students',
        component: Students,
    },
    {
        path: '/students/add',
        name: 'studentsadd',
        component: Students,
    },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;