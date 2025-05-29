<template>
<Head title="Review" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h2 class="text-xl font-bold mb-4">Review</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-xs text-left text-gray-700 border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="px-3 py-2 font-semibold">#</th>
                        <th class="px-3 py-2 font-semibold">Sender</th>
                        <th class="px-3 py-2 font-semibold">Comment</th>
                         <th class="px-3 py-2 font-semibold">Rating</th>
                        <th class="px-3 py-2 font-semibold">Date</th>
                        <th class="px-3 py-2 font-semibold">Publish</th>
                        <th class="px-3 py-2 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(message, index) in messages" :key="message.id"
                     class="border-t hover:bg-gray-50" :class="message.isRead ? '' : 'font-bold'">
                        <td class="px-3 py-2">{{ index + 1 }}</td>
                        <td class="px-3 py-2">{{ message.name }}</td>
                        <td class="px-3 py-2">{{ message.message }}</td>
                        <td class="px-3 py-2">
                            <span v-for="star in message.rating" :key="star" class="text-yellow-500">★</span>
                            <span v-for="star in 5 - message.rating" :key="star" class="text-gray-300">★</span>
                        </td>
                        <td class="px-3 py-2">{{ message.created_at }}</td>
                        <td class="px-3 py-2">{{ message.isPublish  ? 'YES' : 'NO' }}</td>
                        <td class="px-3 py-2">
                            <button
                                class="text-blue-600 hover:underline"
                                @click.prevent="openModal(message)"
                            >Show</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="showModal" class="fixed inset-0 bg-stone-300 opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 min-w-[300px] max-w-[90vw]">
                <h3 class="text-lg font-semibold mb-2">{{ selectedMessage.name }}</h3>
                <p class="mb-1"><strong>Comment:</strong> {{ selectedMessage.message }}</p>
                <p class="mb-1"><strong>Rating:</strong>
                      <span v-for="star in selectedMessage.rating" :key="star" class="text-yellow-500">★</span>
                            <span v-for="star in 5 - selectedMessage.rating" :key="star" class="text-gray-300">★</span>
                </p>

                <p class="mb-1"><strong>Date:</strong> {{ selectedMessage.created_at }}</p>
                <p class="mb-4">{{ selectedMessage.message }}</p>
               
                <!-- add switch publish or not -->
                <div class="flex items-center mb-4">
                    <label for="isPublished" class="mr-2 font-medium">Published:</label>
                    <input
                        id="isPublished"
                        type="checkbox"
                        v-model="selectedMessage.isPublish"
                        @change="togglePublish(selectedMessage)"
                        
                        class="w-5 h-5 accent-blue-600"
                    />
                </div>


                <button
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    @click="closeModal"
                >Close</button>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Review',
        href: '/reviews',
    }
];

defineProps({messages: Array});


const showModal = ref(false)
const selectedMessage = ref({})

const togglePublish = (message) => {
    const newStatus = !message.isPublish
    axios.post(`/reviews/${message.id}/publish`, { is_published: newStatus })
        .then(() => {
            message.is_published = newStatus
        })
        .catch(error => {
            console.error('Error updating publish status:', error)
        })
}

function openModal(message) {
    selectedMessage.value = message
    showModal.value = true

    // Mark message as read if it is not already
    if (!message.is_read) {
        axios.get(`/reviews/${message.id}/read`)
            .then(() => {
                // Optionally, you can update the message state here
                selectedMessage.value.is_read = true
            })
            .catch(error => {
                console.error('Error marking message as read:', error)
            })
    }
}

function closeModal() {
    showModal.value = false
    selectedMessage.value = {}
}
</script>

<style scoped>
.table {
    width: 100%;
    border-collapse: collapse;
}
.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
}
.modal-backdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
       background: rgba(255,255,255,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal {
    background: #fff;
    padding: 24px;
    border-radius: 8px;
    min-width: 300px;
    max-width: 90vw;
}
</style>