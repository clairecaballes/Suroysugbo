<template>

    <Head title="Cebu Legacy" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <form @submit.prevent="handleSubmit" class=" p-6 bg-white rounded shadow space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input id="title" v-model="form.title" type="text" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400" />
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" v-model="form.description" required rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400"></textarea>
            </div>

            <div>
                <label for="map_lat" class="block text-sm font-medium text-gray-700 mb-1">Map Latitude</label>
                <input id="map_lat" v-model="form.map_lat" type="number" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400" />
            </div>

            <div>
                <label for="map_lng" class="block text-sm font-medium text-gray-700 mb-1">Map Longitude</label>
                <input id="map_lng" v-model="form.map_lng" type="number" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400" />
            </div>

            <div>
                <label for="publish" class="block text-sm font-medium text-gray-700 mb-1">Publish</label>
                <select id="publish" v-model="form.ispublished" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400">
                    <option :value="true">Yes</option>
                    <option :value="false">No</option>
                </select>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image Upload</label>
                <input id="image" type="file" @change="handleImageUpload" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Routes</label>
                <table class="min-w-full text-xs text-left text-gray-700 border border-gray-200 rounded-lg mb-2">
                    <thead class="bg-gray-100 text-gray-700 uppercase">
                        <tr>
                            <th class="px-2 py-1">Route Name</th>
                            <th class="px-2 py-1">Vehicle Code</th>
                            <th class="px-2 py-1">Price</th>
                            <th class="px-2 py-1">From</th>
                            <th class="px-2 py-1">To</th>
                            <th class="px-2 py-1">Description</th>
                            <th class="px-2 py-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(route, idx) in form.routes" :key="idx">
                            <td><input v-model="route.route_name" type="text" class="w-full px-2 py-1 border rounded" />
                            </td>
                            <td><input v-model="route.vehicle_code" type="text"
                                    class="w-full px-2 py-1 border rounded" /></td>
                            <td><input v-model="route.price" type="number" class="w-full px-2 py-1 border rounded" /></td>
                            <td><input v-model="route.from" type="text" class="w-full px-2 py-1 border rounded" /></td>
                            <td><input v-model="route.to" type="text" class="w-full px-2 py-1 border rounded" /></td>
                            <td><input v-model="route.description" type="text"
                                    class="w-full px-2 py-1 border rounded" /></td>
                            <td>
                                <button type="button" @click="removeRoute(idx)"
                                    class="text-red-600 hover:underline">Remove</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" @click="addRoute"
                    class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Add Route</button>
            </div>

            <button type="submit"
                class="w-50 py-2 px-4 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                Submit
            </button>
        </form>


    </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({ mode: String, legacyItem: Object });

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Cebu Legacy',
        href: '/cebu-legacy',
    }


];
 if (props.mode == 'create') {
        breadcrumbs.push({
            title: 'Create Legacy',
            href: '/cebu-legacy/edit',
        })
    } else if (props.mode == 'edit') {
        breadcrumbs.push({
            title: 'Edit Legacy',
            href: '/cebu-legacy/edit',
        })
    }


const form = ref({
    id: null,
    title: '',
    description: '',
    map_lat: '',
    map_lng: '',
    ispublished: true,
    image: null,
    mode: props.mode,
    routes: [
    ]
})

onMounted(() => {
    if (props.mode === 'edit' && props.legacyItem) {
        form.value.id = props.legacyItem.id || null
        form.value.title = props.legacyItem.title || ''
        form.value.description = props.legacyItem.description || ''
        form.value.map_lat = props.legacyItem.map_lat || ''
        form.value.map_lng = props.legacyItem.map_lng || ''
        form.value.ispublished = props.legacyItem.ispublished == 1 ? true : false
        form.value.image = null // Reset image for edit mode
        form.value.routes = props.legacyItem.vehicle_routes || []
    }
})

function addRoute() {
    form.value.routes.push({id:null, route_name: '', vehicle_code: '',price:0, from: '', to: '', description: '' })
}

function removeRoute(idx: number) {
    form.value.routes.splice(idx, 1)
}

function handleImageUpload(event) {
    const file = event.target.files[0]
    form.value.image = file
}

function handleSubmit() {
    const formData = new FormData()
    if (form.value.id) {
        formData.append('id', form.value.id)
    }
    formData.append('title', form.value.title)
    formData.append('description', form.value.description)
    formData.append('map_lat', form.value.map_lat)
    formData.append('map_lng', form.value.map_lng)
    formData.append('ispublished', form.value.ispublished)
    formData.append('mode', form.value.mode)
    formData.append('routes', JSON.stringify(form.value.routes))
    if (form.value.image) {
        formData.append('image', form.value.image)
    }

    axios.post('/cebu-legacy/store', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
        .then(response => {
            console.log('Legacy updated successfully:', response.data)
            // Optionally redirect or show success message
        })
        .catch(error => {
            console.error('Error updating legacy:', error)
            // Optionally show error message
        })
}
</script>