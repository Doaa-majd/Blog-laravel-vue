<style>
.col-img{
  float: left;
  width: 25.0%;
  padding-right: 10px
}
.feature-image{
  max-width:100%;
  max-height:100%;
  margin: 0;
}
.img-container{
  overflow: hidden;
}
</style>
<template>
  <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="m-0">Media Library</h5>
                </div>
                <div class="card-body img-container">

                  <div class="col-img" v-for="image in getMedia">
                    <img class="feature-image" :src="'/storage/'+image.file_name" alt="" >
                  </div>

                </div>
              </div>


            </div>
            <!-- /.col-md-6 -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
</template>

<script>
    export default {
        name: "Media",
        data(){
            return{
              tag: '',

            }
        },
        mounted(){
            this.$store.dispatch("allMedia")

        },
        created(){
        },
        computed:{
            getMedia(){
                return this.$store.getters.getAllMedia
            },
        },
        methods:{

        }
    }
</script>
