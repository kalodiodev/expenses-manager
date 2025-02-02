let table = {
    mounted() {
        this.fetchEntries(this.page);
    },
    data() {
        return {
            dialog: false,
            loading: false,
            searchTerm: '',
            dialogTitle: '',

            page: 1,
            totalPages: 1,
            totalEntries: 0,
            toEntry: 0,
            fromEntry: 0,

            entries: [],
            editedItem: {},
            editedIndex: -1,
        }
    },
    methods: {
        onPageChange() {
            this.fetchEntries(this.page);
        },

        entriesUrl: function (page) {
            return this.baseUrl + '?page=' + page + "&search=" + (this.searchTerm ? this.searchTerm : '')
        },

        fetchEntries: function (page) {
            this.loading = true;

            axios.get(this.entriesUrl(page))
                .then(res => {
                    this.setPageInfo(res.data);

                    this.entries = res.data.data;
                    this.loading = false;
                })
                .catch(err => {
                    this.loading = false;
                })
        },

        setPageInfo: function (data) {
            this.fromEntry = data.from;
            this.toEntry = data.to;
            this.page = data.current_page
            this.totalEntries = data.total
            this.totalPages = data.last_page
        },

        clearEditedItem: function () {
            this.editedItem = {}
            this.editedIndex = -1
        },

        isUpdate: function () {
            return this.editedIndex > -1
        },

        save: function (item) {
            if (this.isUpdate()) {
                this.update(item)
            } else {
                this.store(item)
            }
        },

        store: function (item) {
            axios.post(this.baseUrl, this.postData(item))
                .then(res => {
                    this.fetchEntries(this.page)
                    this.close();
                })
                .catch(err => {

                })
        },

        update: function (item) {
            axios.patch(this.baseUrl + '/' + item.id, this.postData(item))
                .then(res => {
                    this.$set(this.entries, this.editedIndex, res.data)
                    this.close()
                });
        },

        delete: function (item) {
            axios.delete(this.baseUrl + '/' + item.id)
                .then(res => {
                    this.fetchEntries(this.page)
                })
                .catch(err => {

                })
        },

        deleteItem: function (item) {
            this.$refs.confirm.open({
                title: this.deleteItemDialogTitle,
                message: this.deleteItemConfirmMessage,
                confirmText: 'Confirm',
                rejectText: 'Cancel'
            }).then(result => {
                if (result) this.delete(item)
            });
        },

        close: function () {
            this.dialog = false
            this.clearEditedItem()
        },

        newItem: function () {
            this.dialogTitle = this.newItemDialogTitle;
            this.editedIndex = -1;
            this.editedItem = this.newItemObject()
            this.dialog = true;
        },

        editItem: function (item) {
            this.editedIndex = this.entries.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogTitle = this.editItemDialogTitle;
            this.dialog = true;
        },

        search: function () {
            this.entries = [];
            this.fetchEntries(1);
        },

        clearSearch: function () {
            this.fetchEntries(1);
        },
    },
}

export default table
