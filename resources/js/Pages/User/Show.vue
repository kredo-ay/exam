<script setup>
import moment from 'moment'
import { Head } from '@inertiajs/inertia-vue3'
import Pagination from '@/Components/Pagination.vue'
import {ref, watch} from 'vue'

const props = defineProps(
    {
        items: {
            type: Object,
            default: () => {}
        },
        user: {
            type: Object,
            default: () => {}
        },
        source :
        {
            type: Object,
            default: () => {}
        }
    }
)

const pagination = ref({})
const information = ref([])
const sources = ref([])
const search = ref({
    from: null,
    to: null,
    src: null,
    dst: null,
    dstvalue: null
})

async function paginate(link) 
{
    let url = !!link.url ? link.url : "/show?page=1"
    await axios.get(`${url}`, {params: {...search.value}})
    .then(({data}) => {
       set(data)
    })
}

function set(data)
{
    pagination.value = data
    filtering(data.data)
}

function filtering(data)
{
    let filtered = data.map((each) => {
        let {src, dst, disposition, duration, billsec, calldate} = each
        let inOut = (src.length <= 4) ? 'OUT' : 'IN'
            billsec = ( dst.slice(0, 2) == "01" ) ? parseInt(billsec) / 10 : parseInt(billsec) / 180
        let dateRef = moment(calldate)
       
        return {src, dst, disposition, inOut, duration, billsec, 'date': dateRef.format('YYYY-MM-DD'), 'time': dateRef.format('hh:mm:ss')}
    })
    information.value = filtered
}

async function process()
{
    await axios.get('/show?page=1', {params: {...search.value}})
    .then(({data}) => {
        set(data)
    })
}

function check()
{
    if(!search.value.dst) search.value.dst = "="
}
watch(()=>props.items, (items) => {
    set(items)
}, {immediate: true})

watch(()=>props.source, (data) => {
    sources.value = data
}, {immediate: true})


</script>

<template>
  <Layout>
    <Head title="Exam" />
    <p>Examinee: {{ props.user.name }}</p>
    <br>
    <div>
        <div>
            Date:
            From:<input type="date" name="" id="" v-model="search.from">
            To:<input type="date" name="" id="" v-model="search.to">
        </div><br>
        <div>
            Source: 
            <select name="" id="" v-model="search.src">
                <option :value="source.src" v-for="(source, index) in sources" :key="index">
                    {{ source.src }}
                </option>
            </select>
        </div><br>
        <div>
            Destination: 
           <span>
            <input type="text" name="" id="" v-model="search.dstvalue" @input="check">
           </span>
            <span v-if="search.dstvalue">
             like <input type="radio" value="like" v-model="search.dst"> = <input type="radio" value="=" v-model="search.dst">
            </span>
        </div>
        <div>
            <button @click="process" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">Search</button>
        </div>
        <br>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                <tr>
                    <th>Source</th>
                    <th>DST</th>
                    <th>Disposition</th>
                    <th>In/Out</th>
                    <th>Duration</th>
                    <th>Billsec</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tr v-for="(info, index) in information" :key="index">
                <td>{{ info.src }}</td>
                <td>{{ info.dst }}</td>
                <td>{{ info.disposition }}</td>
                <td>{{ info.inOut }}</td>
                <td>{{ info.duration }}</td>
                <td>{{ info.billsec }}</td>
                <td>{{ info.date }}</td>
                <td>{{ info.time }}</td>
            </tr>
        </table>
    </div>
    <Pagination :pagination="pagination" @paginate="paginate"/>
  </Layout>
</template>