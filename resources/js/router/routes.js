function page (path) {
    return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
    { path: '/', name: 'index', component: page('index.vue') },
]
