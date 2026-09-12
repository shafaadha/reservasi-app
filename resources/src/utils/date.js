export const calculateDays = (checkIn, checkOut) => {
    if (!checkIn || !checkOut) return 0;

    const startDate = new Date(checkIn);
    const endDate = new Date(checkOut);

    const diffTime = endDate - startDate;
    const days = Math.floor(diffTime / (1000 * 60 * 60 * 24));

    return days > 0 ? days : 0;
};
