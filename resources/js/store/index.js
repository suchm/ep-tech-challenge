import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        journals: {},
    },
    getters: {
        getJournals: (state) => (clientId) => {
            return state.journals[clientId] || [];
        },
    },
    mutations: {
        setJournals(state, { clientId, journals }) {
            Vue.set(state.journals, clientId, journals);
        },
        addJournal(state, { clientId, journal }) {
            if (!state.journals[clientId]) {
                Vue.set(state.journals, clientId, []);
            }
            state.journals[clientId].unshift(journal);
        },
       removeJournal(state, { clientId, journalId }) {
           const journals = state.journals[clientId] || [];
           state.journals[clientId] = journals.filter((j) => j.id !== journalId);
        },
    },
    actions: {
        async fetchJournals({ commit }, clientId) {
            const response = await axios.get(`/clients/${clientId}/journals`);
            commit('setJournals', { clientId, journals: response.data });
        },
        async createJournal({ commit }, { clientId, journal }) {
            const response = await axios.post(`/clients/${clientId}/journals`, journal);
            commit('addJournal', { clientId, journal: response.data });
        },
        async deleteJournal({ commit }, { clientId, journalId }) {
            await axios.delete(`/clients/${clientId}/journals/${journalId}`);
            commit('removeJournal', { clientId, journalId });
        },
    },
});
