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
                    <tr v-for="(message, index) in sortedMessages" :key="message.id"
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
                        class="w-5 h-5 accent-blue-600"
                    />
                </div>


                <button
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                    @click="closeModal"
                >Close</button>
                &nbsp;
                <button
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    @click="onOK"
                >Ok</button>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'
import Swal from 'sweetalert2'

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Review', href: '/reviews' }
]

// Props
const props = defineProps<{ messages: any[] }>()

// Local reactive copy of messages
const localMessages = ref([...props.messages])

// Computed sorted messages (newest first)
const sortedMessages = computed(() => {
    return [...localMessages.value].sort(
        (a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
    )
})

// Modal state
const showModal = ref(false)
const selectedMessage = ref<any>({})

// Open modal and mark message as read
function openModal(message) {
    selectedMessage.value = message
    showModal.value = true

    if (!message.is_read) {
        axios.get(`/reviews/${message.id}/read`)
            .then(() => {
                selectedMessage.value.is_read = true
                // Also update in localMessages for UI
                const index = localMessages.value.findIndex(m => m.id === message.id)
                if (index !== -1) localMessages.value[index].is_read = true
            })
            .catch(error => console.error('Error marking message as read:', error))
    }
}

// Close modal
function closeModal() {
    showModal.value = false
    selectedMessage.value = {}
}

// Toggle publish/unpublish
const onOK = () => {
    axios.post(`/reviews/${selectedMessage.value.id}/publish`, {
        is_published: selectedMessage.value.isPublish
    })
        .then(() => {
            Swal.fire({
                icon: selectedMessage.value.isPublish ? 'success' : 'info',
                title: selectedMessage.value.isPublish ? 'Success' : 'Info',
                text: selectedMessage.value.isPublish
                    ? 'Message has been published successfully.'
                    : 'Message has been unpublished successfully.'
            })
            // Update localMessages so table reflects change
            const index = localMessages.value.findIndex(m => m.id === selectedMessage.value.id)
            if (index !== -1) localMessages.value[index].isPublish = selectedMessage.value.isPublish
        })
        .catch(error => console.error('Error updating publish status:', error))
}

// Function to add a new review (can be called after submitting a form)
async function addNewReview(newReview) {
    try {
        const response = await axios.post('/reviews', newReview)
        // Add the new review to the localMessages array
        localMessages.value.unshift(response.data)
    } catch (error) {
        console.error('Error creating review:', error)
    }
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