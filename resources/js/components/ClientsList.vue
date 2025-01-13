<template>
    <div>
        <h1>
            Clients
            <a href="/clients/create" class="float-right btn btn-primary">+ New Client</a>
        </h1>

        <div v-if="successMessage"
             class="alert alert-success text-center">
            <span class="font-semibold">{{ successMessage }}</span> was successfully removed
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Number of Bookings</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in userClients" :key="client.id">
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.bookings_count }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" :href="`/clients/${client.id}`">View</a>
                        <button class="btn btn-danger btn-sm" @click="confirmAndDeleteClient(client)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientsList',

    props: ['clients'],

    data() {
        return {
            userClients: [...this.clients],
            successMessage: '',
        }
    },

    methods: {
        confirmAndDeleteClient(client) {
            // Show confirmation prompt
            if (confirm(`Are you sure you want to delete ${client.name}?`)) {
                this.deleteClient(client);
            }
        },

        deleteClient(client) {
            axios.delete(`/clients/${client.id}`)
                .then(response => {
                    if ( response.data === 'Deleted' ) {

                        this.userClients = this.userClients.filter(c => c.id !== client.id);

                        this.successMessage = client.name;

                        setTimeout(() => {
                            this.successMessage = '';
                        }, 3000);
                    }
                })
                .catch(error=> {
                    console.log(error);
                });
        }
    }
}
</script>
