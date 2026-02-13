<script setup>
import { computed } from "vue";
import { useSidebar } from "../../composables/useSidebar";

const props = defineProps({
  side: {
    type: String,
    default: "left",
  },
  variant: {
    type: String,
    default: "sidebar",
  },
  collapsible: {
    type: String,
    default: "offcanvas",
  },
});

const { isMobile, state, openMobile, setOpenMobile } = useSidebar();

const side = computed(() => props.side);
const collapsible = computed(() => props.collapsible);

function closeMobile() {
  setOpenMobile(false);
}
</script>

<template>
  <!-- collapsible none -->
  <div
    v-if="collapsible === 'none'"
    class="bg-white text-gray-900 flex h-full w-64 flex-col border-r"
  >
    <slot />
  </div>

  <!-- mobile sidebar -->
  <div v-else-if="isMobile">
    <div
      v-if="openMobile"
      class="fixed inset-0 z-40 bg-black/50"
      @click="closeMobile"
    ></div>

    <div
      v-if="openMobile"
      class="fixed inset-y-0 z-50 w-72 bg-white shadow-lg flex flex-col"
      :class="side === 'left' ? 'left-0' : 'right-0'"
    >
      <slot />
    </div>
  </div>

  <!-- desktop sidebar -->
  <div
    v-else
    class="hidden md:block"
    :data-state="state"
    :data-side="side"
  >
    <div
      class="transition-all duration-200 ease-linear bg-white border-r h-screen"
      :class="state === 'collapsed' ? 'w-14' : 'w-64'"
    >
      <slot />
    </div>
  </div>
</template>
