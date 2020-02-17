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

<style postcss="less">
.slideout-menu {
    width: 256px;
    background-color: #2C2C30;
    position: fixed;
    height: 100vh;
    grid-column: span 2;
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