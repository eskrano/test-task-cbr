<template>
    <div>
        <select @change="$emit('per_page_changed', $event.target.value)">
            <option v-for="item in [5,10,50,100]" :value="item" :selected="item  === currentValue">
                {{ item }}
            </option>
        </select>
    </div>
</template>
<script>
export default {
    data: () => ({
        currentValue: 10,
    }),
    props: {
        currentValueProp: {
            type: Number,
            default: 10,
        }
    },
    created() {
        this.currentValue = this.currentValueProp
    }
}
</script>
