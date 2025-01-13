<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Client Info</h2>
                    <table>
                        <tbody>
                            <tr>
                                <th class="text-gray-600 pr-3">Name</th>
                                <td>{{ client.name }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Email</th>
                                <td>{{ client.email }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Phone</th>
                                <td>{{ client.phone }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Address</th>
                                <td>{{ client.address }}<br/>{{ client.postcode + ' ' + client.city }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div>
                    <button class="btn" :class="{'btn-primary': currentTab === 'bookings', 'btn-default': currentTab != 'bookings'}" @click="switchTab('bookings')">Bookings</button>
                    <button class="btn" :class="{'btn-primary': currentTab === 'journals', 'btn-default': currentTab != 'journals'}" @click="switchTab('journals')">Journals</button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab === 'bookings'">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="mb-3">List of client bookings</h3>
                        <select v-model="selectedFilter" @change="filterBookings" class="form-select focus:outline-none border-2 p-2 rounded-sm">
                            <option value="all">All bookings</option>
                            <option value="future">Future bookings only</option>
                            <option value="past">Past bookings only</option>
                        </select>
                    </div>

                    <template v-if="filteredBookings && filteredBookings.length > 0">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Time</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="booking in filteredBookings" :key="`booking-${booking.id}`">
                                <td>{{ formatDateRange(booking.start, booking.end) }}</td>
                                <td>{{ booking.notes }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no bookings.</p>
                    </template>

                </div>

                <!-- Journals -->
                <div class="bg-white rounded p-4" v-if="currentTab === 'journals'">
                    <div class="flex justify-between items-center mb-3">
                        <h3>List of client journals</h3>
                        <button
                            class="btn btn-primary"
                            @click="showCreateJournalModal = true"
                        >
                            + Add Journal
                        </button>
                    </div>

                    <template v-if="journals.length > 0">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Journal Details</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="journal in journals" :key="`journal-${journal.id}`">
                                <td class="font-semibold">{{ formatDate(journal.date) }}</td>
                                <td>{{ journal.body }}</td>
                                <td>
                                    <button
                                        class="btn btn-primary btn-sm mb-2"
                                        @click="viewJournal(journal)"
                                    >
                                        View
                                    </button>
                                    <button
                                        class="btn btn-danger btn-sm"
                                        @click="deleteJournal(journal)"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>
                    <template v-else>
                        <p class="text-center">No journals available.</p>
                    </template>

                    <!-- Journal Form Modal -->
                    <div
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                        tabindex="-1"
                        role="dialog"
                        v-if="showCreateJournalModal"
                    >
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                            <h3 class="text-lg font-semibold mb-4">Add Journal</h3>
                            <form @submit.prevent="createJournal(newJournal)">
                                <div class="form-group mb-4">
                                    <label for="journalText" class="block text-sm font-medium text-gray-700">Journal Text</label>
                                    <textarea
                                        id="journalText"
                                        class="form-control block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2"
                                        v-model="newJournal.body"
                                        required
                                    ></textarea>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button
                                        type="button"
                                        class="btn btn-secondary px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400"
                                        @click="showCreateJournalModal = false"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                                    >
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Journal View Modal -->
                    <div
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                        v-if="showViewJournalModal"
                    >
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                            <h3 class="text-lg font-semibold mb-4">Journal Details</h3>
                            <div class="mb-4">
                                <p class="font-semibold">{{ formatDate(selectedJournal.date) }}</p>
                                <p>{{ selectedJournal.body }}</p>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button
                                    type="button"
                                    class="btn btn-secondary px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400"
                                    @click="showViewJournalModal = false"
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {formatDate, formatDateRange} from "../utils/formatDate";

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            selectedFilter: 'all',
            filteredBookings: this.client.bookings,
            journals: [],
            selectedJournal: null,
            showViewJournalModal: false,
            showCreateJournalModal: false,
            newJournal: {
                body: '',
            },
        }
    },

    methods: {
        formatDate,
        formatDateRange,

        switchTab(newTab) {
            this.currentTab = newTab;

            if (this.currentTab === 'journals') {
                this.fetchJournals();
            }
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        filterBookings() {
            const now = new Date();

            if (this.selectedFilter === 'future') {
                this.filteredBookings = this.client.bookings.filter(booking => new Date(booking.start) > now);

            } else if (this.selectedFilter === 'past') {
                this.filteredBookings = this.client.bookings.filter(booking => new Date(booking.start) < now);

            } else {
                this.filteredBookings = this.client.bookings;
            }
        },

        fetchJournals() {
            axios.get(`/clients/${this.client.id}/journals`)
                .then(response => {
                    this.journals = response.data;
                })
                .catch(error => {
                    console.error('Error fetching journals:', error);
                });
        },

        createJournal(journalData) {
            axios.post(`/clients/${this.client.id}/journals`, journalData)
                .then(response => {
                    this.journals.unshift(response.data);
                    this.showCreateJournalModal = false;
                    this.newJournal.body = '';
                })
                .catch(error => {
                    console.error('Error creating journal:', error);
                });
        },

        deleteJournal(journal) {
            if (confirm(`Are you sure you want to delete this journal?`)) {
                axios.delete(`/clients/${this.client.id}/journals/${journal.id}`)
                    .then(() => {

                        this.journals = this.journals.filter(j => j.id !== journal.id);
                    })
                    .catch(error => {
                        console.error('Error deleting journal:', error);
                    });
            }
        },

        viewJournal(journal) {
            this.selectedJournal = journal;
            this.showViewJournalModal = true;
        },
    }
}
</script>
