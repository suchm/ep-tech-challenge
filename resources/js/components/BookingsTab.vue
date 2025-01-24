<template>
    <div>
        <div class="flex justify-between items-center mb-3">
            <h3 class="mb-3">List of client bookings</h3>
            <select
                v-model="bookingsSelect"
                class="form-select focus:outline-none border-2 p-2 rounded-sm"
            >
                <option value="all">All bookings</option>
                <option value="future">Future bookings only</option>
                <option value="past">Past bookings only</option>
            </select>
        </div>

        <template v-if="filteredBookings.length > 0">
            <table class="table">
                <thead>
                <tr>
                    <th>Time</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="booking in filteredBookings" :key="booking.id">
                    <td>{{ formatDateRange(booking.start, booking.end) }}</td>
                    <td>{{ booking.notes }}</td>
                    <td>
                        <button
                            class="btn btn-danger btn-sm"
                            @click="deleteBooking(booking)"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </template>

        <template v-else>
            <p class="text-center">The client has no bookings.</p>
        </template>
    </div>
</template>

<script>
import { formatDateRange } from '../utils/formatDate';

export default {
    name: 'BookingsTab',
    props: ['bookings'],
    data() {
        return {
            bookingsSelect: 'all',
        };
    },
    computed: {
        filteredBookings() {
            const now = new Date();
            if (this.bookingsSelect === 'future') {
                return this.bookings.filter((b) => new Date(b.start) > now);
            } else if (this.bookingsSelect === 'past') {
                return this.bookings.filter((b) => new Date(b.start) < now);
            }
            return this.bookings;
        },
    },
    methods: {
        formatDateRange,

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },
    },
};
</script>
