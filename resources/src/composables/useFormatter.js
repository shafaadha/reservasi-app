export function useFormatter() {
    const formatDate = (date) => {
        if (!date) return "-";

        return new Date(date).toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "short",
            year: "numeric",
        });
    };

    const formatCurrency = (amount) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            maximumFractionDigits: 0,
        }).format(amount);
    };

    const statusClass = (status) => {
        const classes = {
            pending: "bg-yellow-100 text-yellow-700",
            confirmed: "bg-green-100 text-green-700",
            check_in: "bg-blue-100 text-blue-700",
            check_out: "bg-purple-100 text-purple-700",
            completed: "bg-gray-100 text-gray-700",
            cancelled: "bg-red-100 text-red-700",
        };

        return classes[status] || "bg-gray-100 text-gray-600";
    };

    const statusLabel = (status) => {
        const labels = {
            pending: "Pending",
            confirmed: "Confirmed",
            check_in: "Check In",
            check_out: "Check Out",
            completed: "Completed",
            cancelled: "Cancelled",
        };

        return labels[status] || status;
    };

    return {
        formatDate,
        formatCurrency,
        statusClass,
        statusLabel,
    };
}
