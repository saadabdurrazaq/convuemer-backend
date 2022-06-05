<template>
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">{{ pageTitle }}</h1>
            </div> <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right"> 
                <li
                v-for="(breadcrumb, idx) in breadcrumbList"
                :key="idx"
                @click="routeTo(idx)"
                class="breadcrumb-item"
                :class="{ 'linked': !!breadcrumb.link, 'active': !!breadcrumb.active, 'home': !!breadcrumb.home }"
                >
                    {{breadcrumb.name}}
                </li> 
              </ol>
            </div> <!-- /.col -->
          </div> <!-- /.row -->
        </div>
      </div>
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