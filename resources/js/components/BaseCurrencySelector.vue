<template>
    <div>
        <select class="form-control" @change="onSelect($event.target.value)" v-if="items.length > 0">
            <option :value="0">-</option>
            <option v-for="item in items" :key="item.id" :value="item.id" :selected="selected_value === item.id">
                {{ item.name }}
            </option>
        </select>
    </div>
</template>
<script>
export default {
    data: () => ({
        selected_value: null,
        items: [],
    }),
    props: {
        currencies: {
            type: Array,
            default: () => ([]),
        }
    },
    created() {
        if (this.currencies.length === 0) {
            this.loadFlattenCurrencies()
        } else {
            this.items = this.currencies;
        }
    },
    methods: {
        async loadFlattenCurrencies() {
            let _items = await fetch(`/api/currency/all_flatten`).then(res => res.json())
            this.items = _items.data;

        },
        onSelect(id) {
            this.$emit('currency_selected', id);
            this.selected_value = id;
        }
    }
}
</script>
