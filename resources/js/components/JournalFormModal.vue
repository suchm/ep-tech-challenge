<template>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        tabindex="-1"
        role="dialog"
    >
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">{{ title }}</h3>
            <form @submit.prevent="handleSubmit">
                <div class="form-group mb-4">
                    <label for="journalText" class="block text-sm font-medium text-gray-700">Journal Text</label>
                    <textarea
                        id="journalText"
                        class="form-control block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2"
                        v-model="journal.body"
                        required
                    ></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button
                        type="button"
                        class="btn btn-secondary px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400"
                        @click="$emit('close')"
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
</template>

<script>
export default {
    name: 'JournalFormModal',
    props: {
        title: {
            type: String,
            default: 'Add Journal',
        },
        journalData: {
            type: Object,
            default: () => ({ body: '' }),
        },
    },
    data() {
        return {
            journal: { ...this.journalData },
        };
    },
    methods: {
        handleSubmit() {
            this.$emit('save', this.journal);
        },
    },
};
</script>
