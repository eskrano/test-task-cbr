<template>
    <div>
        <select @change="onSelect($event.target.value)" v-if="currencies.length > 0">
            <option v-for="item in currencies" :key="item.id" :value="item.id" :selected="selected_value === item.id">
                {{ item.name }}
            </option>
        </select>
    </div>
</template>
<script>
export default {
    data: () => ({
        selected_value: null,
    }),
    props: {
        currencies: {
            type: Array,
            default: []
        }
    },
    methods: {
        onSelect(id) {
            this.$emit('currency_selected', id);
            this.selected_value = id;
        }
    }
}
</script>
