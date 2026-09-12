<script setup>
defineProps({
    rooms: {
        type: Array,
        default: () => [],
    },

    loading: {
        type: Boolean,
        default: false,
    },

    selectable: {
        type: Boolean,
        default: false,
    },
});
</script>
