<template>
    <div class="flex items-center justify-center pt-10 lg:px-0 sm:px-6 px-4 overflow-x-hidden">
        <div class="w-full flex items-center justify-between border-gray-200">
            <div class="flex mx-auto">

                <!--Desktop-->
                <div class="flex w-full hidden lg:flex">
                    <div class="flex items-center pb-3 text-gray-600 hover:text-indigo-700 cursor-pointer mr-3" @click="paginate(props.pagination.prev_page_url)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        <p class="text-sm ml-1 font-medium leading-none">prev</p>
                    </div>
                    
                        <template v-for="(link, index) in props.pagination.links" :key="index" >
                            <a v-if="!link.label.includes('Previous') && !link.label.includes('Next')" 
                                class="text-sm font-medium leading-none cursor-pointer border-b pb-3 mr-4 px-2"
                                :class="link.active ? activeLink : defaultLink"
                                @click.prevent="paginate(link.url)"
                            >
                                {{link.label}}
                            </a>
                        </template>
                    
                    <div class="flex items-center pb-3 text-gray-600 hover:text-indigo-700 cursor-pointer" @click="paginate(props.pagination.next_page_url)">
                        <p class="text-sm font-medium leading-none mr-1">next</p>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>

                 <!--Mobile-->
                <div class="flex w-full flex lg:hidden">
                    <div class="flex items-center pb-3 text-gray-600 hover:text-indigo-700 cursor-pointer mr-3" @click="paginate(props.pagination.prev_page_url)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        <p class="text-sm ml-1 font-medium leading-none text-black">prev</p>
                    </div>

                    <span class="text-sm font-medium leading-none cursor-pointer border-b pb-3 mr-4 px-2">{{props.pagination.current_page}}</span>

                    <div class="flex items-center pb-3 text-gray-600 hover:text-indigo-700 cursor-pointer" @click="paginate(props.pagination.next_page_url)">
                        <p class="text-sm font-medium leading-none mr-1">next</p>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

    const activeLink = 'text-indigo-700 border-indigo-400'
    const defaultLink = 'border-transparent hover:border-indigo-400 text-gray-600 hover:text-indigo-700'
    const props = defineProps({
        pagination:{
            type: Object,
            default: {}
        }
    })

    const emit = defineEmits(['paginate'])

    function getParameterByName(name, url = window.location.href) {
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    function paginate(url){
        emit('paginate', {
            url: url,
            current_page: parseInt(getParameterByName('page', url))
        })
    }
</script>