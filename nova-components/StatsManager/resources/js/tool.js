Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'stats-manager',
      path: '/stats-manager',
      component: require('./components/Tool'),
    },
  ])
})
