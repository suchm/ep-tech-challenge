import { format } from 'date-fns';

function formatDateRange(start, end) {
    const startDate = new Date(start);
    const endDate = new Date(end);

    // Format as "Monday 19 January 2020, 14:00 to 15:00"
    return `${format(startDate, 'EEEE d MMMM yyyy, HH:mm')} to ${format(endDate, 'HH:mm')}`;
}

export { formatDateRange };
