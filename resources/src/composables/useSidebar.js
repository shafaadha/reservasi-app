import { ref } from "vue";
import { useIsMobile } from "./useIsMobile";

const openMobile = ref(false);

export function useSidebar() {
    const isMobile = useIsMobile();

    function setOpenMobile(value) {
        openMobile.value = value;
    }

    return {
        isMobile,
        openMobile,
        setOpenMobile,
    };
}
