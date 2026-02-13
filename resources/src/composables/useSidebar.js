import { inject } from "vue";

export const SIDEBAR_KEY = Symbol("SIDEBAR_KEY");

export function useSidebar() {
    const ctx = inject(SIDEBAR_KEY);

    if (!ctx) {
        throw new Error("useSidebar must be used inside <SidebarProvider>.");
    }

    return ctx;
}
