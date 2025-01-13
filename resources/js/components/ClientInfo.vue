<template>
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
                    <td>{{ client.address }}<br />{{ client.postcode }} {{ client.city }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ClientInfo',
    props: ['client'],
};
</script>
