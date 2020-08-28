<template>
    <div>
        <section class="content">
            <div class="row justify-content-around" >
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Post List</h3>

                            <div class="card-tools">
                                <button class="btn btn-primary">
                                    <router-link to="/add-post" style="color:#fff"> Add New Post</router-link>
                                </button>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>

                                    <th>Sl</th>
                                    <th>User</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Photo</th>

                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(post,index) in allpost" class="post-row">
                                    <td>{{index+1}}</td>
                                    <td v-if="post.user">{{post.user.name}}</td>
                                    <td v-if="post.category">{{post.category.cat_name}}</td>
                                    <td><div>{{post.title | sortlength(20,"---")}}</div>
                                      <div class="post_action" style="display:none">
                                      <router-link :to="`edit-post/${post.id}`">Edit</router-link>
                                      <a href="" @click.prevent = "deletePost(post.id)" >Delete</a>
                                    </div></td>
                                    <td>{{post.description | sortlength(40,"....")}}</td>
                                    <td v-if="post.image"><img :src="ourImage(post.image.file_name)" alt="" width="40" height="50"></td>

                                </tr>
                                </tbody>


                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
</template>

<script>
    export default {
        name: "List",
        data(){
            return{
              getdata:'allposts',
              postdata:[],
            }
        },
        mounted(){
            this.$store.dispatch('gelAllPost')

            let routelist = this.$route.path;
            if(routelist.indexOf('post-tag-list') !== -1){
              this.getdata='tags';
              axios.get(`/postsbytag/${this.$route.params.tagid}`)
              .then(({data})=>(this.postdata=data.postsbytag));

              console.log(this.$route.path)
            }
        },
        computed:{
            allpost(){
              if(this.getdata==='allposts'){
                return this.$store.getters.getAllPost
              }else if (this.getdata==='tags') {
                return this.postdata
              }
            }
        },
        methods:{
            ourImage(img){
              //  return "uploadimage/"+img;
              return "storage/"+img;
            },
            deletePost(id){
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                  axios.get('/delete/'+id).then(()=>{
                    Swal.fire(
                      'Deleted!',
                      'Your post has been deleted.',
                      'success'
                    )
                    this.$store.dispatch('gelAllPost')
                  }).catch(()=>{
                     swal("Failed!", "There was something wronge.", "warning");
                  });
                }
              })

            }//end delete post
        }
    }
</script>
