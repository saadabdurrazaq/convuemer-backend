<template>
<div class="breadcrumb">
    <div class="container">
      <div class="breadcrumb-inner">
        <ul class="list-inline list-unstyled">
          <li
                v-for="(breadcrumb, idx) in breadcrumbList"
                :key="idx"
                @click="routeTo(idx)"
                class="breadcrumb-item"
                :class="{ 'linked': !!breadcrumb.link, 'active': !!breadcrumb.active, 'home': !!breadcrumb.home }"
                >
                    {{breadcrumb.name}}
                </li> 
        </ul>
      </div>
      <!-- /.breadcrumb-inner -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.breadcrumb -->
</template>
<script>
export default {
    name: 'Breadcrumb',

    data() {
        return {
            breadcrumbList: [],
            pageTitle: ''
        }
    },

    mounted() {
        this.updateList()
    },

    watch: {
        '$route'() {
            this.updateList()
        }
    },

    methods: {
        routeTo(pRouteTo) {
            if(this.breadcrumbList[pRouteTo].link) {
                this.$router.push(this.breadcrumbList[pRouteTo].link)
            }
        }, 
        updateList() {
            this.breadcrumbList = this.$route.meta.breadcrumb
            this.pageTitle = this.$route.meta.pageTitle
        }
    }
}
</script>
<style>
.linked {
    cursor: pointer;
    font-size: 1em;
    font-weight: normal;
}
.home {
    color: #4798e8
}
</style>