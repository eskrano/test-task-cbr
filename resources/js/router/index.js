import routes from './routes'
import Router from 'vue-router'

const router = createRouter()

export default router

/**
 * Create a new router instance.
 *
 * @return {Router}
 */
function createRouter () {
    return new Router({
        mode: 'history',
        routes
    })
}
