import { format } from 'date-fns';

function formatDate(date, formatString = 'EEEE d MMMM yyyy'){
    const dateString = new Date(date);

    return format(dateString, formatString);
}

function formatDateRange(start, end) {
    const startDate = new Date(start);
    const endDate = new Date(end);

    // Format as "Monday 19 January 2020, 14:00 to 15:00"
    return `${format(startDate, 'EEEE d MMMM yyyy, HH:mm')} to ${format(endDate, 'HH:mm')}`;
}

export { formatDate, formatDateRange };
