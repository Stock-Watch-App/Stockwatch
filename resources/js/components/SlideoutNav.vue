<template>
    <Slideout menu="#menu" panel="#panel" :toggleSelectors="['.toggle-button']" @on-open="open"></Slideout>
</template>

<script>
  import Slideout from 'vue-slideout'

  export default {
    name: 'app',
    components: {
      Slideout
    },
    methods: {
      open: function () {
        console.log('slideoutOpen')
      }
    }
  }
</script>

<style lang=scss>
/* this looks very scary and wrong */
.slideout-menu {
    @apply bg-gray-800 text-white shadow-md p-3 col-span-2 h-screen fixed z-0 hidden overflow-y-scroll scrolling-touch inset-y-0;
    width: 256px;
}

.slideout-menu-left {
    left: 0;
}

.slideout-menu-right {
    right: 0;
}

.slideout-panel {
    position: relative;
    z-index: 1;
    will-change: transform;
    min-height: 100vh;
}

.slideout-open,
.slideout-open body,
.slideout-open .slideout-panel {
    overflow: hidden;
}

.slideout-open .slideout-menu {
    display: block;
}

@media screen and (min-width: 780px) {
    .slideout-panel {
      margin-left: 256px;
    }

    .slideout-menu {
      display: block;
    }

    .toggle-button {
      display: none;
    }
}
</style>