<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>
        <div class="flex">

            <ClientInfo :client="client" />

            <div class="w-2/3">

                <div>
                    <button
                        class="btn"
                        :class="{ 'btn-primary': currentTab === 'bookings', 'btn-default': currentTab !== 'bookings' }"
                        @click="currentTab = 'bookings'"
                    >
                        Bookings
                    </button>
                    <button
                        class="btn"
                        :class="{ 'btn-primary': currentTab === 'journals', 'btn-default': currentTab !== 'journals' }"
                        @click="currentTab = 'journals'"
                    >
                        Journals
                    </button>
                </div>

                <div v-if="currentTab === 'bookings'" class="bg-white rounded p-2">
                    <BookingsTab :bookings="client.bookings" />
                </div>

                <keep-alive>
                    <div v-if="currentTab === 'journals'" class="bg-white rounded p-2">
                        <JournalsTab :client-id="client.id" />
                    </div>
                </keep-alive>

            </div>
        </div>
    </div>
</template>

<script>
import ClientInfo from './ClientInfo.vue';
import BookingsTab from './BookingsTab.vue';
import JournalsTab from './JournalsTab.vue';

export default {
    name: 'ClientShow',
    components: {ClientInfo, BookingsTab, JournalsTab},
    props: ['client'],
    data() {
        return {
            currentTab: 'bookings',
            selectedFilter: 'all',
        };
    },
};
</script>
