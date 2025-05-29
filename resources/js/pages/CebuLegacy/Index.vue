<template>

    <Head title="Cebu Legacy" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <h2 class="text-xl font-bold mb-4">Cebu Legacy</h2>

        <!-- create tailwind button with label new -->
        <div class="mb-4">
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                @click="$inertia.visit('/cebu-legacy/edit')">New</button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-xs text-left text-gray-700 border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="px-3 py-2 font-semibold">#</th>
                        <th class="px-3 py-2 font-semibold">title</th>
                        <th class="px-3 py-2 font-semibold">description</th>
                        <th class="px-3 py-2 font-semibold">long</th>
                        <th class="px-3 py-2 font-semibold">lat</th>
                        <th class="px-3 py-2 font-semibold">Publish</th>
                        <th class="px-3 py-2 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in legacyItems" :key="item.id" class="border-t hover:bg-gray-50">
                        <td class="px-3 py-2">{{ index + 1 }}</td>
                        <td class="px-3 py-2">{{ item.title }}</td>
                        <td class="px-3 py-2">{{ item.description }}</td>
                        <td class="px-3 py-2">{{ item.long }}</td>
                        <td class="px-3 py-2">{{ item.lat }}</td>
                        <td class="px-3 py-2">{{ item.ispublished }}</td>
                        <td class="px-3 py-2">
                            <button class="text-blue-600 hover:underline"
                                @click.prevent="$inertia.visit(`/cebu-legacy/edit/${item.id}`)">Edit</button>
                            &nbsp;
                            <button class="text-red-600 hover:underline" @click.prevent="onDelte(item)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- <div v-if="showModal" class="fixed inset-0 bg-stone-300 opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-lg p-6 min-w-[300px] max-w-[90vw]">
                <h3 class="text-lg font-semibold mb-2">{{ selectedMessage.subject }}</h3>
                <p class="mb-1"><strong>From:</strong> {{ selectedMessage.name }}</p>
                <p class="mb-1"><strong>Date:</strong> {{ selectedMessage.created_at }}</p>
                <p class="mb-4">{{ selectedMessage.message }}</p>
                <button
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    @click="closeModal"
                >Close</button>
            </div>
        </div> -->
    </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import Swal from 'sweetalert2';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Cebu Legacy',
        href: '/messages',
    }
];

defineProps({ legacyItems: Array });


const showModal = ref(false)
const selectedMessage = ref({})

const onDelte = (item) => {
    Swal.fire({
        title: 'Are you sure?',
        text: `You won't be able to revert ${item.title}!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/cebu-legacy/delete/${item.id}`)
                .then(() => {
                    // Optionally, you can show a success message or refresh the page
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: 'Legacy item deleted successfully.',
                    })
                    // Refresh the page or update the state to reflect the deletion
                    window.location.reload()
                })
                .catch(error => {
                    console.error('Error deleting legacy item:', error)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to delete legacy item.',
                    })
                })
        }
    })

}

function openModal(message) {
    selectedMessage.value = message
    showModal.value = true

    // Mark message as read if it is not already
    if (!message.is_read) {
        axios.get(`/messages/${message.id}/read`)
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

.table th,
.table td {
    border: 1px solid #ddd;
    padding: 8px;
}

.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.7);
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