<template>
    <div>
        <div v-if="items.length === 0" class="alert alert-primary">
            <p>Loading...</p>
        </div>
        <div v-else>

            <Paginator
                :current_page="page"
                :has_more_pages="paginator.has_more_pages"
                :max_page="paginator.total_pages"
                @page_click="changePage"

            />
        </div>
    </div>
</template>
<script>
import Paginator from "../components/Paginator";
export default {
    components: {Paginator},
    data: () => ({
        items: [],
        page_size: 10,
        page: 1,
        base_currency_id: null,
        paginator: {
            total_pages: 0,
            current_page: 0,
            has_more_pages: false,
        }
    }),
    created() {
        let vm = this;
        this.fetchItems().then(data => vm.parseResponse(data));
    },
    methods: {
        fetchItems() {
            return fetch(`/api/currency/all?page_size=${this.page_size}&page=${this.page}`).then(res => res.json())
        },
        parseResponse(data) {
            this.items = data.data;
            this.paginator.has_more_pages = data.meta.last_page !== 1;
            this.paginator.current_page = data.meta.current_page;
            this.paginator.total_pages = data.meta.last_page;
        },
        changePage(page) {
            console.log(page)
        }
    }
}
</script>
