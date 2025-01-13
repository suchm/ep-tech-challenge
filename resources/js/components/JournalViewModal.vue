<template>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        tabindex="-1"
        role="dialog"
    >
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
            <h3 class="text-lg font-semibold mb-4">Journal Details</h3>
            <div class="mb-4">
                <p>
                    <span class="font-semibold">Date:</span>
                    <span>{{ journal.date }}</span>
                </p>
                <p>
                    <span class="font-semibold">Text:</span>
                    <span>{{ journal.body }}</span>
                </p>
            </div>
            <div class="flex justify-end space-x-2">
                <button
                    type="button"
                    class="btn btn-secondary px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400"
                    @click="$emit('close')"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'JournalViewModal',
    props: {
        journal: {
            type: Object,
            required: true,
        },
    },
};
</script>
