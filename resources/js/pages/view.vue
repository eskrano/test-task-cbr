<template>
    <div>
        <div class="alert alert-primary" v-if="null === item || null === history_records">
            <p>Loading data...</p>
        </div>
        <div v-else>
            <div class="row">
                <div class="col-sm-4 col-md-4 col-xs-4">
                    <BaseCurrencySelector @currency_selected="baseCurrencyChanged"/>
                </div>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                <th>Name</th>
                <th>Nominal</th>
                <th>Today rate</th>
                <th>Min / Max / Avg all time</th>
                </thead>
                <tbody>
                <tr>
                    <td>{{ item.name }} [{{ item.code }} - {{ item.num_code }}]</td>
                    <td>{{ item.nominal }}</td>
                    <td>{{ parseFloat(item.rate).toFixed(4) }}</td>
                    <td>{{ parseFloat(item.min).toFixed(4) }} / {{ parseFloat(item.max).toFixed(4) }} /
                        {{ parseFloat(item.avg).toFixed(4) }}
                    </td>
                </tr>
                </tbody>
            </table>
            <hr>
            <h3>Chart</h3>

            <div class="row">
                <div class="col-sm-4 col-md-4 col-xs-6">
                    <input class="form-control" type="date" v-model="date_start"/>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-6">
                    <input class="form-control" type="date" v-model="date_to"/>
                </div>
            </div>

            <Chart :options="chartOptions"/>
        </div>
    </div>
</template>
<script>
import BaseCurrencySelector from '../components/BaseCurrencySelector'
import {Chart} from 'highcharts-vue'
import Highcharts from 'highcharts'

export default {
    components: {BaseCurrencySelector, Chart},
    data: () => ({
        id: null,
        date_start: null,
        date_to: null,
        base_currency_id: null,
        item: null,
        history_records: null,
        chartOptions: {
            title: {
                text: 'Exchange rate over time'
            },
            series: [{
                data: []
            }],
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Exchange rate'
                }
            },
            legend: {
                enabled: false
            },
        }
    }),
    created() {
        this.id = this.$route.params.id;
        this.loadData();
    },
    watch: {
        date_to(changed) {
            this.loadData()
        },
        date_start(changed) {
            this.loadData()
        }
    },
    methods: {
        loadData() {
            let vm = this
            this.fetchCurrency().then(res => vm.processCurrencyResponse(res))
            this.fetchData().then(res => vm.processHistoryResponse(res))
        },
        baseCurrencyChanged(base_currency) {
            if (null === base_currency || '0' === base_currency || 0 === base_currency) {
                this.base_currency_id = null;
            } else {
                this.base_currency_id = base_currency;
            }

            this.loadData()
        },
        processCurrencyResponse(response) {
            this.item = response.data
        },
        processHistoryResponse(response) {
            this.history_records = response.data
            let vm = this;
            this.chartOptions.series[0].data = [];
            this.history_records.forEach((item) => {
                vm.chartOptions.series[0].data.push([new Date(Date.parse(item.date)).getTime(), parseFloat(item.rate)])
            })
        },
        fetchCurrency(id = this.id, base_currency = this.base_currency_id) {
            let uri = `/api/currency/${id}`

            if (null !== base_currency) {
                uri += `?base_currency_id=${base_currency}`
            }
            return fetch(uri).then(res => res.json());
        },
        fetchData(id = this.id, date_start = this.date_start, date_to = this.date_to, base_currency_id = this.base_currency_id) {
            let uri = `/api/currency/${id}/history?`

            if (null !== date_start) {
                uri += `date_from=${date_start}&`
            }

            if (null !== date_to) {
                uri += `date_to=${date_to}&`
            }

            if (null !== base_currency_id && 0 !== base_currency_id && '0' !== base_currency_id) {
                uri += `base_currency_id=${base_currency_id}`
            }

            return fetch(uri).then(res => res.json())
        }
    }
}
</script>
