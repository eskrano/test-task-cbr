<template>
    <div>
        <div class="row mt-3">
            <div v-for="page in max_page" class="col-sm-1">
                <a href="#" @click="$emit('page_click', page)" class="btn btn-outline-primary btn-sm">{{
                        page
                    }}</a>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data: () => ({}),
    props: {
        current_page: Number,
        max_page: Number,
        has_more_pages: Boolean,
    },
    created() {

    }
}
</script>
