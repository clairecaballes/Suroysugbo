<template>
  <div>
    <!-- Instruction Popup -->
    <div
      v-if="showInstruction"
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
      <div
        class="relative bg-white p-4 rounded-xl shadow-lg w-[90%] max-w-md sm:w-[70%] sm:max-w-lg"
      >
        <!-- Close button -->
        <button
          @click="closeInstruction"
          class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl"
        >
          ✖
        </button>

        <!-- Image -->
        <img
          src="/images/instruction.png"
          alt="Game Instructions"
          class="w-full h-auto object-contain"
        />

        <!-- Optional caption -->
        <p class="text-center text-sm mt-2 sm:mt-3">
          Tap ❌ to close or use ❓ anytime
        </p>
      </div>
    </div>

    <!-- Floating Help Icon -->
    <button
      @click="openInstruction"
      class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 bg-blue-600 text-white w-12 h-12 flex items-center justify-center rounded-full shadow-lg hover:bg-blue-700 z-40"
    >
      ❓
    </button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showInstruction: false,
      triggeredOnce: false,
    };
  },
  mounted() {
    window.addEventListener("scroll", this.checkScroll);
  },
  beforeUnmount() {
    window.removeEventListener("scroll", this.checkScroll);
  },
  methods: {
    checkScroll() {
      const funFactsSection = document.getElementById("fun-facts");
      if (!funFactsSection || this.triggeredOnce) return;

      const rect = funFactsSection.getBoundingClientRect();
      if (rect.top < window.innerHeight && rect.bottom >= 0) {
        this.showInstruction = true;
        this.triggeredOnce = true;
      }
    },
    closeInstruction() {
      this.showInstruction = false;
    },
    openInstruction() {
      this.showInstruction = true;
    },
  },
};
</script>
