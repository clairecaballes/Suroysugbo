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
                <label for="coordinates" class="block text-sm font-medium text-gray-700 mb-1">Coordinates</label>
                <input id="coordinates" v-model="form.coordinates" type="text" step="any"
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

            <!-- upload music -->

            <div>
                <label for="audio" class="block text-sm font-medium text-gray-700 mb-1">Audio Upload</label>
                <input id="audio" type="file" @change="handleAudioUpload" accept="audio/*"
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
                            <td><input v-model="route.price" type="number" class="w-full px-2 py-1 border rounded" />
                            </td>
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

            <!-- create a section list of upload image -->

            <section class="mt-4" v-if="mode === 'edit'">
                <hr class="my-4" />
                <h3 class="text-lg font-semibold mb-2">Street View</h3>
                <!-- add modal enter coordinates,title and upload image -->
                <button type="button" @click="addTourSite"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Add Tour Site
                </button>

                <div v-if="tourSites" class="flex items-center space-x-4">
                    <div v-for="(image, index) in tourSites" :key="index" class="relative w-32 h-32 mb-2">
                        <img :src="image.imageUrl" :alt="image.title"
                            class="w-full h-full object-cover rounded shadow" />

                        <!-- Delete Icon -->
                        <button type="button" @click="removeImage(index)"
                            class="absolute top-0 right-0 bg-red-600 text-white rounded-full p-1 hover:bg-red-700">
                            <Trash2 class="h-4 w-4" />
                        </button>

                        <!-- Edit Icon -->
                        <button type="button" @click="editImage(index)"
                            class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-1 hover:bg-blue-700">
                            <Edit class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <div v-else class="text-sm text-gray-500">No image uploaded</div>
            </section>

            <button type="submit"
                class="w-50 py-2 px-4 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                Submit
            </button>
        </form>

        <div v-if="isModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
                <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-800" @click="closeModal">
                    ✕
                </button>
                <h2 class="text-lg font-semibold mb-4">{{ tourTitle }} Tour Site</h2>
                <div class="space-y-4">
                    <div>
                        <label for="modal-title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input id="modal-title" v-model="modalForm.title" type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400" />
                    </div>
                    <div>
                        <label for="modal-coordinates"
                            class="block text-sm font-medium text-gray-700 mb-1">Coordinates</label>
                        <input id="modal-coordinates" v-model="modalForm.coordinates" type="text"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400" />
                    </div>
                    <div>
                        <label for="modal-image" class="block text-sm font-medium text-gray-700 mb-1">Upload
                            Image</label>
                        <input id="modal-image" type="file" @change="handleModalImageUpload" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    </div>

                    <div>
                        <label for="modal-ispublish"
                            class="block text-sm font-medium text-gray-700 mb-1">Publish</label>
                        <select id="modal-ispublish" v-model="modalForm.ispublished"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400">
                            <option :value="1">Yes</option>
                            <option :value="0">No</option>
                        </select>
                    </div>

                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" @click="closeModal"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="button" @click="saveTourSite"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Save
                    </button>
                </div>
            </div>
        </div>


    </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import Swal from 'sweetalert2';
import { Trash2, Edit } from 'lucide-vue-next';
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

const tourSites = ref(props.legacyItem?.tourSites || []);
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
    coordinates: '',
    ispublished: true,
    image: null,
    mode: props.mode,
    audio: null,
    routes: [
    ]
})

const images = ref<File[]>([]); // Store selected images for upload
const tourTitle = ref('Add')
const isModalOpen = ref(false); // Modal state
const modalForm = ref({
    id: null,
    title: '',
    coordinates: '',
    image: null,
});

const addTourSite = () => {
    tourTitle.value = 'Add';
    modalForm.value = {
        id: null,
        title: '',
        coordinates: '',
        image: null,
    };
    openModal();
};

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const handleModalImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        modalForm.value.image = target.files[0];
    }
};

const handleAudioUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.value.audio = target.files[0];
    }
};

const removeImage = (index: number) => {

    //add confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to delete this tour site?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/cebu-legacy/image-delete/${tourSites.value[index].id}`)
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Tour site deleted successfully!',
                    });
                    tourSites.value.splice(index, 1);
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.response?.data?.message || 'Failed to delete the tour site.',
                    });
                });
        }
    });

};
const editImage = (index: number) => {
    tourTitle.value = 'Edit';
    if (props.legacyItem.tourSites) {
        const tourSite = props.legacyItem.tourSites[index];
        modalForm.value.id = tourSite.id; // Assuming each tour site has an ID
        modalForm.value.title = tourSite.title;
        modalForm.value.coordinates = tourSite.coordinates;
        modalForm.value.ispublished = tourSite.ispublished;

        openModal();
    }
};

const storeTourSite = () => {
    if (images.value.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Please select images to upload.',
        });
        return;
    }

    const formData = new FormData();
    formData.append('cebu_legacy_id', form.value.id || ''); // Append legacy ID if available
    images.value.forEach((image, index) => {
        formData.append(`images[${index}]`, image);
    });


};

const saveTourSite = () => {
    // Validate modal form fields

    if (tourTitle.value === 'Add') {
        if (!modalForm.value.title || !modalForm.value.coordinates || !modalForm.value.image) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please fill in all fields and upload an image.'
            });
            return;
        }
    }

    if (tourTitle.value === 'Edit') {
        if (!modalForm.value.title || !modalForm.value.coordinates) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please fill in all fields and upload an image.',
            });
            return;
        }
    }


    // Add the new tour site to the legacyItem.tourSites array
    if (!form.value.tourSites) {
        form.value.tourSites = [];
    }
    form.value.tourSites.push({
        title: modalForm.value.title,
        coordinates: modalForm.value.coordinates,
        image: modalForm.value.image,
    });

    // Prepare FormData for API request
    const formData = new FormData();
    if (modalForm.value.id) {
        formData.append('id', modalForm.value.id); // Append ID if editing
    }
    formData.append('cebu_legacy_id', form.value.id || ''); // Append legacy ID if available
    formData.append('title', modalForm.value.title);
    formData.append('coordinates', modalForm.value.coordinates);
    formData.append('image', modalForm.value.image);
    formData.append('ispublished', modalForm.value.ispublished ? '1' : '0'); // Convert boolean to string

    // Send API request to upload the tour site
    axios.post('/cebu-legacy/image-upload', formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    })
        .then((response) => {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Tour site added successfully!',
            });

            // Optionally update the UI with the response data
            if (response.data && response.data.tourSites) {
                tourSites.value = response.data.tourSites;

            }

            closeModal(); // Close the modal after successful submission
        })
        .catch((error) => {
            const errorMessage = error.response?.data?.message || 'Failed to upload the tour site.';
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: errorMessage,
            });
        });
};

onMounted(() => {
    if (props.mode === 'edit' && props.legacyItem) {
        form.value.id = props.legacyItem.id || null
        form.value.title = props.legacyItem.title || ''
        form.value.description = props.legacyItem.description || ''
        form.value.coordinates = props.legacyItem.coordinates || ''
        form.value.ispublished = props.legacyItem.ispublished == 1 ? true : false
        form.value.image = null // Reset image for edit mode
        form.value.routes = props.legacyItem.vehicle_routes || []
    }
})

function addRoute() {
    form.value.routes.push({ id: null, route_name: '', vehicle_code: '', price: 0, from: '', to: '', description: '' })
}

function removeRoute(idx: number) {
    //get id 
    const route = form.value.routes[idx]
    form.value.routes.splice(idx, 1)
    if (route.id) {
        // If the route has an ID, it means it's an existing route that needs to be deleted
        axios.delete(`/cebu-legacy/route/${route.id}`)
            .then(response => {
                Swal.fire({ // Show success message
                    icon: 'success',
                    title: 'Success!',
                    text: 'Route deleted successfully!',
                });
            })
            .catch(error => {
                Swal.fire({ // Show error message
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to delete route.',
                });
            })
    }
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
    formData.append('coordinates', form.value.coordinates)
    formData.append('ispublished', form.value.ispublished)
    formData.append('mode', form.value.mode)
    if (form.value.audio) {
        formData.append('audio', form.value.audio)
    }
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
            Swal.fire({ // Show success message
                icon: 'success',
                title: 'Success!',
                text: 'Cebu Legacy item saved successfully!',
            });
        })
        .catch(error => {
            Swal.fire({ // Show error message
                icon: 'error',
                title: 'Error!',
                text: 'Failed to save Cebu Legacy item.',
            });
        })
}
</script>