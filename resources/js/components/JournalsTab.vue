<template>
    <div>
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
                <tr v-for="journal in journals" :key="journal.id">
                    <td>{{ formatDate(journal.date) }}</td>
                    <td>{{ journal.body }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm mb-1" @click="viewJournal(journal)">
                            View
                        </button>
                        <button
                            class="btn btn-danger btn-sm"
                            @click="deleteJournal(journal.id)"
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

        <JournalFormModal
            v-if="showCreateJournalModal"
            @close="showCreateJournalModal = false"
            @save="handleCreateJournal"
        />
        <JournalViewModal
            v-if="showViewJournalModal"
            :journal="selectedJournal"
            @close="showViewJournalModal = false"
        />
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import { formatDate } from '../utils/formatDate';
import JournalFormModal from './JournalFormModal.vue';
import JournalViewModal from './JournalViewModal.vue';

export default {
    name: 'JournalsTab',
    components: { JournalFormModal, JournalViewModal },
    props: ['clientId'],
    data() {
        return {
            selectedJournal: null,
            showCreateJournalModal: false,
            showViewJournalModal: false,
        };
    },
    computed: {
        ...mapGetters(['getJournals']),
        journals() {
            return this.getJournals(this.clientId);
        },
    },
    created() {
        if (!this.journals.length) {
            this.fetchJournals(this.clientId);
        }
    },
    methods: {
        formatDate,
        ...mapActions(['fetchJournals', 'createJournal', 'deleteJournal']),
        async handleCreateJournal(journal) {
            await this.createJournal({ clientId: this.clientId, journal });
            this.showCreateJournalModal = false;
        },
        async deleteJournal(journalId) {
            await this.deleteJournal({ clientId: this.clientId, journalId });
        },
        viewJournal(journal) {
            this.selectedJournal = journal;
            this.showViewJournalModal = true;
        },
    },
};
</script>
