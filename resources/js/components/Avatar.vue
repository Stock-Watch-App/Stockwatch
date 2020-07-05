<template>
  <img
    src="../../../storage/app/public/avatar-default.svg"
    class="avatar"
    :width="width"
    :height="height"
  />
</template>

<!-- :alt="user.name" -->
<!-- fallback/default img ../../../storage/app/public/avatar-default.svg -->

<script>
export default {
  props: {
    user: Object,
    width: String,
    height: String
  },
  data() {
    return {};
  }
};
</script>
