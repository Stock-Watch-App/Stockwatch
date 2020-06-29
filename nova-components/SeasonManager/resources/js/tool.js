Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'season-manager',
            path: '/season-manager',
            component: require('./components/Tool'),
        },
    ])
})

