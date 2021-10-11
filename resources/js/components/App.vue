<template>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-4 col-md-4 col-xs-12">
                <Sidebar/>
            </div>
            <div class="col-sm-8 col-md-8 col-xs-12">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
import Sidebar from './Sidebar'

export default {
    data: () => ({
        test: true,
    }),
    components: {
        Sidebar
    }
}
</script>
