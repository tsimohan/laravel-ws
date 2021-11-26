<template>
    <div>
        <div class="bg-gray-900 py-2">
            <div class="container mx-auto text-white px-3">
                <div class="flex justify-start">
                    <router-link :to="{ name: 'students' }" class="flex justify-start items-center mr-4 border-b-2 border-gray-300 py-2">
                        <users-icon size="24" class="mr-2"></users-icon>
                        Students
                    </router-link>
                </div>
            
            </div>
        </div>
        <div class="container mx-auto py-3 px-3">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import { UsersIcon, GlobeIcon } from 'vue-feather-icons';
    export default {
        components: {
            UsersIcon, GlobeIcon
        }
    }
</script>