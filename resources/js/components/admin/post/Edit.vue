<style>
.ck-content { height:500px; }
.feature-img{
  margin-left: 200px;
  margin-right: 150px;
}
.tags-input-tag{
  background-color:#e9ecef;
  padding: 5px;
  border-radius: 3px;
  margin-right: 10px;
}
.tags-input-remove{
  background-color: #e9ecef;
  border: none;
}
.tags-input-text{
  padding: 5px;
  border-radius: 4px;
  border: 1px solid #d7d1d1;
}
</style>
<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-around">
                <!-- left column -->
                <div class="col-md-10">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Post</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" enctype="multipart/form-data" @submit.prevent="updatePost()">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="postId">Update Post </label>
                                    <input type="text" @blur="addSlug()" class="form-control" id="postId" placeholder="Add Post title" v-model="form.title" name="title" :class="{ 'is-invalid': form.errors.has('title') }">
                                    <has-error :form="form" field="title"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="postId">Slug </label>
                                    <input type="text" @click="addSlug()" class="form-control" id="postId" placeholder="slug" v-model="form.slug" name="slug" >
                                </div>
                                <div class="form-group">
                                    <label for="descriptionId">Add New Description</label>
                                    <ckeditor :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>

                                    <has-error :form="form" field="description"></has-error>
                                </div>

                                <div class="form-group" >
                                    <label>Select</label>
                                    <select class="form-control" :class="{ 'is-invalid': form.errors.has('cat_id') }" v-model="form.cat_id">
                                        <option disabled value="">Select One</option>
                                        <option :value="category.id" v-for="category in getallCategory">{{category.cat_name}}</option>

                                    </select>
                                    <has-error :form="form" field="cat_id"></has-error>
                                </div>
                                <div class="form-group" >
                                    <label for="exampleInputFile">Upload Feature Image</label>
                                     <div class="input-group">
                                      <div class="custom-file">
                                        <input @change = "changePhoto($event)" name="photo" class="custom-file-input" id="exampleInputFile" type="file" :class="{ 'is-invalid': form.errors.has('photo') }">
                                        <label class="custom-file-label" for="exampleInputFile">Upload</label>
                                      </div>
                                        <img class="feature-img" :src="updateImage()" alt="" width="200" height="100">
                                    </div>
                                    <has-error :form="form" field="photo"></has-error>
                                </div>
                                <label >Tags</label>

                                      <vue-tags-input
                                      v-model="tag"
                                      :tags="form.tags"
                                      :autocomplete-items="tagsMatche"
                                      :disabled="form.tags.length > 9"
                                      @tags-changed="newTags => form.tags = newTags"/>

                                  <span>{{form.tags.length}} / 10</span>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    export default {
        name: "Edit",
        data(){
            return{
              tag: '',
              tagsarray:[],
              editor: ClassicEditor,
                editorConfig: {
                    // The configuration of the editor.
                },
                form: new Form({
                    title:'',
                    description:'',
                    cat_id:'',
                    photo:'',
                    slug:'',
                    tags: [],
                })
            }
        },
        mounted(){
            this.$store.dispatch("allCategory")
            this.getTagsArray();

        },
        created(){
            axios.get(`/post/${this.$route.params.postid}`)
                .then((response)=>{
                    console.log(response.data)
                    this.form.fill(response.data.post)
                    this.form.tags=response.data.tags
                    this.form.photo =response.data.photo
                })
        },
        computed:{
            getallCategory(){
                return this.$store.getters.getCategory
            },
            tagsMatche() {
              return this.tagsarray.filter(i => {
                return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
              });
            },//end tagsMatche function
        },
        methods:{
          getTagsArray(){
            axios.get("/tagspost").then(({data})=>(
                this.tagsarray=data
            ));

          },
          addSlug(){
            let slug =this.form.title;
            slug = slug.replace(/\s+/g, '-').toLowerCase();
            this.form.slug = slug;
          //  console.log(slug);
          },
          updateImage(){
              let img = this.form.photo;
              if(img.length>100){
                  return  this.form.photo
              }else{
                return "../storage/"+img;
              }
          },
            changePhoto(event){
                let file = event.target.files[0];
                if(file.size>1048576){
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        footer: '<a href>Why do I have this issue?</a>'
                    })
                }else{
                    let reader = new FileReader();
                    reader.onload = event => {
                        this.form.photo = event.target.result
                        console.log(event.target.result)
                    };
                    reader.readAsDataURL(file);
                }
            },
            updatePost(){
                this.form.post(`/update/${this.$route.params.postid}`)
                    .then(()=>{
                        this.$router.push('/post-list')
                        toast({
                            type: 'success',
                            title: 'Post Updated successfully'
                        })
                    })
                    .catch(()=>{
                    })
            },

        }
    }
</script>
