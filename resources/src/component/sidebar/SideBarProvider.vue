<script setup>
import { ref, computed, provide, onMounted, onUnmounted } from "vue";
import { SIDEBAR_KEY } from "../../composables/useSidebar";
import { useIsMobile } from "../../composables/useIsMobile";

const SIDEBAR_COOKIE_NAME = "sidebar_state";
const SIDEBAR_COOKIE_MAX_AGE = 60 * 60 * 24 * 7;

const props = defineProps({
  defaultOpen: {
    type: Boolean,
    default: true,
  },
});

const isMobile = useIsMobile();
const open = ref(props.defaultOpen);
const openMobile = ref(false);

const state = computed(() => (open.value ? "expanded" : "collapsed"));

function setOpen(value) {
  open.value = value;
  document.cookie = `${SIDEBAR_COOKIE_NAME}=${value}; path=/; max-age=${SIDEBAR_COOKIE_MAX_AGE}`;
}

function setOpenMobile(value) {
  openMobile.value = value;
}

function toggleSidebar() {
  if (isMobile.value) {
    openMobile.value = !openMobile.value;
  } else {
    setOpen(!open.value);
  }
}

function handleKeyDown(event) {
  if (event.key === "b" && (event.ctrlKey || event.metaKey)) {
    event.preventDefault();
    toggleSidebar();
  }
}

onMounted(() => {
  window.addEventListener("keydown", handleKeyDown);
});

onUnmounted(() => {
  window.removeEventListener("keydown", handleKeyDown);
});

provide(SIDEBAR_KEY, {
  state,
  open,
  setOpen,
  toggleSidebar,
  isMobile,
  openMobile,
  setOpenMobile,
});
</script>

<template>
  <div class="group/sidebar-wrapper flex min-h-screen w-full bg-gray-50">
    <slot />
  </div>
</template>
