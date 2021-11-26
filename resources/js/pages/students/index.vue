<template>
    <div class="flex w-full py-5 flex-col">
        <div class="flex w-full mb-4">
            <form class="w-full" @submit="(e) => handleSubmit(e)">
                <div v-if="message.length > 0" :class="`${Object.keys(errors).length > 0 ? 'text-red-500' : 'text-green-500'} mb-4`">{{message}}</div>
                <div class="flex flex-col flex-auto md:flex-row justify-between md:items-stretch ">
                    <div class="md:mr-2 flex flex-col w-full">
                        <label class="block text-gray-700 text-sm font-bold mb-1" for="name">Name</label>
                        <input :class="`appearance-none border-2 rounded w-full py-2 px-3 text-gray-900 focus:outline-none hover:border-gray-300 focus:border-gray-400 placeholder-gray-400 ${errors && errors.name ? ' border-red-300 bg-red-200 ' : ''} ${isLoading ? 'disabled' : ''} `" id="name" type="text" v-model="name" placeholder="Name" :disabled="isLoading">
                        <div v-if="errors && errors.name" class="text-red-500 mt-1">{{errors.name[0]}}</div>
                    </div>
                    <div class="mt-4 md:mt-0 md:ml-2 md:mr-2 flex flex-col w-full">
                        <label class="block text-gray-700 text-sm font-bold mb-1" for="department">Departments</label>
                        <select :class="`border-2 rounded w-full py-2 px-3 ${department === '' ? 'text-gray-400' : 'text-gray-900'} focus:outline-none hover:border-gray-300 focus:border-gray-400 ${errors && errors.department ? ' border-red-300 bg-red-200 ' : ''} ${isLoading ? 'disabled' : ''} `" v-model="department" id="department" :disabled="isLoading">
                            <option class="text-gray-400" value="">Select Department</option>
                            <option class="text-gray-900" v-for="dept in departments" :key="dept.id" :value="dept.id">{{dept.name}}</option>
                        </select>
                        <div v-if="errors && errors.department" class="text-red-500 mt-1">{{errors.department[0]}}</div>
                    </div>
                    <div class="mt-4 md:mt-0 md:ml-2 w-full">
                        <label class="block text-gray-700 text-sm font-bold mb-1 invisible hidden md:block" for="department">test</label>
                        <button :class="`bg-gray-900 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:bg-gray-700 ${isLoading ? 'disabled' : ''} `" :disabled="isLoading">
                            <div class=" flex items-center justify-center " v-if="!isLoading"><user-plus-icon size="24" class="mr-2"></user-plus-icon> Add Student</div>
                            <div class=" flex items-center justify-center " v-if="isLoading"><loader-icon size="24" class="mr-2"></loader-icon> Adding</div>
                        </button>
                        <div class="text-red-500 mt-1 invisible hidden md:block">test</div>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex w-full mb-4">
            <table class="w-full">
                <tbody>
                    <tr class="border-b-2">
                        <td class="py-2 font-bold">#</td>
                        <td class="py-2 font-bold">Name</td>
                        <td class="py-2 font-bold">Department</td>
                    </tr>
                    <tr v-for="(tableinfo, index) in tabledata" :key="tableinfo.id" :class="`${tabledata[Object.keys(tabledata)[Object.keys(tabledata).length - 1]] === tableinfo ? '' : 'border-b-2'}`">
                        <td class="py-2">{{index + 1}}.</td>
                        <td class="py-2 flex flex-row"><user-icon size="24" class="mr-2"></user-icon> {{tableinfo.name}}</td>
                        <td class="py-2">{{tableinfo.department.name}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { UserPlusIcon, LoaderIcon, UserIcon } from 'vue-feather-icons';

export default {
    data() {
        return { tabledata: [], isLoading: false, name: '', department: '', departments: [], errors: [], message: '' }
    },
    methods: {
        loadData: async function() {
            await axios.get('/api/students')
                    .then(({data}) => this.tabledata = data.message)
                    .catch(err => console.log(err));
            await axios.get('/api/departments')
                    .then(({data}) => this.departments = data.message)
                    .catch(err => console.log(err));
        }, 
        handleSubmit: async function(e) {
            e.preventDefault();
            this.isLoading = true;
            this.message = "";
            this.errors = [];
            const {department, name} = this;
            let formdata = {name, department};
            await axios.post('/api/students', formdata)
                    .then(({data}) => {
                        // this.errors = [];
                    }).catch(err => {
                        if(err.response) {
                            if(err.response.data && err.response.data.errors) {
                                this.errors = err.response.data.errors;
                                this.isLoading = false;
                                this.message = err.response.data.message;
                            }
                        }
                    });
        }
    },
    components: {
        UserPlusIcon, LoaderIcon, UserIcon
    },    
    async mounted() {
        await this.loadData();
        
        this.$echo.channel('StudentCreated')
            .listen('CreateStudentEvent', ({response}) => {
                let _self = this;
                _self.isLoading = false;
                _self.message = response.message;
                _self.name = '';
                _self.department = '';
                let data = {id: response.data[0].id, name: response.data[0].name, department: response.data[0].department};
                _self.tabledata.push(data);
                setTimeout(() => {
                    _self.message = '';
                }, 5000);
            });
    }
}
</script>