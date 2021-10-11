<template>
    <div>

    </div>
</template>
<script>
export default {
    data: () => ({
        id: null
    }),
    created() {
        this.id = this.$route.params.id;
    },
    methods: {
        fetchData(id) {

        }
    }
}
</script>
