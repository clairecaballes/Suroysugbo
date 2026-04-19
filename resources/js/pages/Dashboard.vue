
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { CheckCircle, MessageCircle, Star } from 'lucide-vue-next';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  LinearScale,
  CategoryScale
} from 'chart.js'
import { Line } from 'vue-chartjs'
import axios from 'axios'
import { computed, ref, onMounted, onUnmounted } from 'vue'

const props = defineProps<{
  totalLegacyItems: number
  totalMessages: number
  totalReviews: number
  monthlyLabels: string[]
  monthlyRequests: number[]
}>()
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

// Register Chart.js components
ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  LinearScale,
  CategoryScale
)

const monthlyLabels = ref<string[]>(props.monthlyLabels)
const monthlyRequests = ref<number[]>(props.monthlyRequests)

const chartData = computed(() => ({
  labels: monthlyLabels.value,
  datasets: [
    {
      label: 'Requests',
      data: monthlyRequests.value,
      borderColor: '#42A5F5',
      backgroundColor: 'rgba(66, 165, 245, 0.2)',
      fill: true,
      tension: 0.4,
    }
  ]
}))

const fetchChartData = async () => {
  try {
    const response = await axios.get('/dashboard/chart-data')
    monthlyLabels.value = response.data.labels
    monthlyRequests.value = response.data.data
  } catch (error) {
    console.error('Unable to refresh dashboard chart data:', error)
  }
}

let refreshInterval: number | undefined
onMounted(() => {
  fetchChartData()
  refreshInterval = window.setInterval(fetchChartData, 30000)
})

onUnmounted(() => {
  if (refreshInterval) {
    window.clearInterval(refreshInterval)
  }
})

const chartOptions = {
  responsive: true,
  plugins: {
    legend: { position: 'top' },
    title: {
      display: true,
      text: 'Monthly visitors',
    }
  }
}
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-blue-600 dark:bg-blue-700 flex items-center justify-between p-6 shadow">
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-2">Total Sites</h2>
                        <p class="text-3xl font-bold text-white">{{ props.totalLegacyItems }}</p>
                    </div>
                    <CheckCircle class="h-24 w-24 text-white" />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-green-600 dark:bg-green-700 flex items-center justify-between p-6 shadow">
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-2">Total Messages</h2>
                        <p class="text-3xl font-bold text-white">{{ props.totalMessages }}</p>
                    </div>
                    <MessageCircle class="h-24 w-24 text-white" />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-purple-600 dark:bg-purple-700 flex items-center justify-between p-6 shadow">
                    <div>
                        <h2 class="text-lg font-semibold text-white mb-2">Total Reviews</h2>
                        <p class="text-3xl font-bold text-white">{{ props.totalReviews }}</p>
                    </div>
                    <Star class="h-24 w-24 text-white" />
                </div>
            </div>
             <div class="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-gray-800 p-6 shadow">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Monthly Visitor</h2>
                <div class="h-[400px]">
                    <Line :data="chartData" :options="chartOptions" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
