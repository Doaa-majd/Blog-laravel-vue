<template>
  <ul class="list-group">
        <comment v-for="comment in comments" :key="comment.id" :comment="comment" :level="level" :collection="collection"></comment>
    </ul>
</template>

<script>
    export default {
      props: ['collection','comments', 'level'],
        computed:{

        },
        beforeCreate: function () {
            this.$options.components.Comment = require('./Comment.vue').default

        }
  }
</script>
