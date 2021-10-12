<template>
    <div>
        <div v-if="items.length === 0" class="alert alert-primary">
            <p>Loading...</p>
        </div>
        <div v-else>
            <div class="row">
                <div class="col-sm-4 col-md-4 col-xs-4">
                    <PerPageSelector :current-value-prop="page" @per_page_changed="perPageChanged"/>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-4">
                    <BaseCurrencySelector :currencies="items" @currency_selected="baseCurrencyChanged"/>
                </div>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                <th>
                    Name [Char code - Num code]
                </th>
                <th>
                    Rate
                </th>
                <th>
                    Max / Min / Average Rates
                </th>
                </thead>
                <tbody>
                <tr v-for="item in items">
                    <td>
                        <router-link :to="{name:'view', params: {id:item.id}}">{{ item.name }} [{{ item.code }} -
                            {{ item.num_code }}]
                        </router-link>
                    </td>
                    <td>
                        {{ parseFloat(item.rate).toFixed(4) }}
                    </td>
                    <td>
                        {{ parseFloat(item.max).toFixed(4) }} / {{ parseFloat(item.min).toFixed(4) }} /
                        {{ parseFloat(item.avg).toFixed(4) }}
                    </td>
                </tr>
                </tbody>
            </table>
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
import PerPageSelector from '../components/PerPageSelector'
import BaseCurrencySelector from '../components/BaseCurrencySelector'

export default {
    components: {Paginator, PerPageSelector, BaseCurrencySelector},
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
        fetchItems(page_size = this.page_size, page = this.page, base_currency = this.base_currency_id) {
            let uri = `/api/currency/all?page_size=${page_size}&page=${page}`

            if (null !== base_currency && 0 !== base_currency && '0' !== base_currency) {
                uri += `&base_currency_id=${base_currency}`
            }

            return fetch(
                uri
            ).then(
                res => res.json()
            )
        },
        parseResponse(data) {


            this.page = data.meta.current_page;
            this.page_size = data.meta.per_page;
            this.paginator.has_more_pages = data.meta.last_page !== 1;
            this.paginator.current_page = data.meta.current_page;
            this.paginator.total_pages = data.meta.last_page;
            this.items = data.data;
        },
        changePage(page) {
            let vm = this;
            this.fetchItems(this.page_size, page).then(data => vm.parseResponse(data))
        },
        perPageChanged(per_page) {
            let vm = this;
            this.fetchItems(per_page, 1).then(data => vm.parseResponse(data))
        },
        baseCurrencyChanged(base_currency) {
            let vm = this;
            this.base_currency_id = base_currency
            this.fetchItems(this.page_size, this.page, base_currency).then(data => vm.parseResponse(data))
        }
    }
}
</script>
