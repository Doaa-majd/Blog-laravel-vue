<template>
    <div>
        <section class="content">
            <div class="row justify-content-around" >
                <div class="col-8 ">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Category List</h3>

                            <div class="card-tools">
                                <button class="btn btn-primary">
                                    <router-link to="/add-category" style="color:#fff"> Add Category </router-link>
                                </button>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>
                                        <select name="" id="" v-model="select" @change="deleteSelected">
                                            <option value="">Select</option>
                                            <option value="">Delete all</option>
                                        </select><br>
                                        <input type="checkbox" @click.prevent="selectAll" v-model="all_select">
                                        <span v-if="all_select==false">Check All</span>
                                        <span v-else>Uncheck All</span>
                                    </th>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Actions</th>

                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="(category,index) in getallCategory" :key="category.id">
                                    <td><input type="checkbox" v-model="categoryItem" :value="category.id" ></td>
                                    <td>{{index+1}}</td>
                                    <td>{{category.cat_name}}</td>
                                    <td>{{category.created_at | timeformat}}</td>
                                    <td>
                                        <router-link :to="`/edit-category/${category.id}`">Edit</router-link>
                                        <a href="" @click.prevent = "deletecategory(category.id)" >Delete</a>
                                    </td>
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
                categoryItem:[],
                select:'',
                all_select:false
            }
        },
        mounted(){
            this.$store.dispatch("allCategory")
        },
        computed:{
           getallCategory(){
            return this.$store.getters.getCategory
           }
        },
        methods:{
            deletecategory(id){
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
              axios.get('/category/'+id).then(()=>{
                Swal.fire(
                  'Deleted!',
                  'Your category has been deleted.',
                  'success'
                )
                this.$store.dispatch("allCategory")
              }).catch(()=>{
                 swal("Failed!", "There was something wronge.", "warning");
              });
            }
          })

            },
            deleteSelected(){
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
                axios.get('/deletecategory/'+this.categoryItem).then(()=>{
                  Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
                  this.categoryItem = []
                  this.$store.dispatch("allCategory")
                }).catch(()=>{
                   swal("Failed!", "There was something wronge.", "warning");
                });
              }
          })
                //console.log(this.categoryItem)

            },
            selectAll(){
                if(this.all_select==false){
                    this.all_select = true
                    for(var category in this.getallCategory){
                        this.categoryItem.push(this.getallCategory[category].id)
                    }
                }else{
                    this.all_select = false
                    this.categoryItem = []
                }
            }
        }
    }
</script>
