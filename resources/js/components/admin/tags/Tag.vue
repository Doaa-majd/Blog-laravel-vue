<template>
  <section class="content">
      <div class="container-fluid">
          <div class="row">
            <div class="col-md-5">
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add new tag</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" @submit.prevent="addnewTag()">
                <div class="card-body">
                  <div class="form-group">
                    <label for="tagname" class="control-label">Name</label>

                    <div class="">
                      <input type="text" class="form-control" id="tagname" placeholder="Tag name" v-model="form.tagname" name="tagname" :class="{ 'is-invalid': form.errors.has('tagname') }">
                      <has-error :form="form" field="tagname"></has-error>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="tagslug" class="control-label">Slug</label>

                    <div class="">
                      <input type="text" class="form-control" @click="addSlug()" id="tagslug" placeholder="slug" v-model="form.slug" name="slug">
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows="3" placeholder="" v-model="form.description"></textarea>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">Add Tag</button>
                </div>
                <!-- /.card-footer -->
              </form>
            </div>

            </div>
            <div class="col-md-7">
              <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Tags</h3>
                          <div class="card-tools">
                            <pagination :data="getTagObject" @pagination-change-page="getTags"></pagination>
                          </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                          <select class="bulk-action" name="" id="" >
                              <option value="">Bulk Action</option>
                              <option value="">Delete all</option>
                          </select><br>
                          <table class="table">
                            <tbody>
                              <tr>
                                <th style="width: 8%"><input type="checkbox"></th>
                                <th style="width: 23%">Tag</th>
                                <th style="width: 23%">Slug</th>
                                <th style="width: 36%">Description</th>
                                <th style="width: 10%">Count</th>
                            </tr>
                            <tr v-for="(tag,index) in alltags" class="tag-row" :class="{editing: index == tagindex}" >
                              <td class="view"><input type="checkbox" ></td>
                              <td class="view"><div><router-link :to="`/post-tag-list/${tag.id}`"> {{tag.name}} </router-link></div>
                                <div class="tag_action" style="display:none">
                                  <a herf="" @click.prevent="showEdit(index,tag)"> Edit </a>
                                  <a href="" @click.prevent = "deletetag(tag.id)" > Delete</a>
                                </div>
                              </td>
                              <td class="view">{{tag.slug}}</td>
                              <td class="view">{{tag.description}}</td>
                              <td class="view">{{tag.post.length}}</td>  <!--<span v-for="tt in tag.post">{{tt.title}}</span> -->

                              <td colspan="5" class="edit row">
                                <form @submit.prevent="updateTag(tag.id)">
                                    <div class="form-row">
                                      <div class="form-group col-md-3">
                                        <input type="text" class="form-control form-control-sm" name="name" v-model="formup.name" placeholder="Tag Name" :class="{ 'is-invalid': formup.errors.has('name') }">
                                        <has-error :form="formup" field="name"></has-error>
                                      </div>
                                      <div class="form-group col-md-3">
                                        <input type="text" class="form-control form-control-sm" v-model="formup.slug" placeholder="Slug">
                                      </div>
                                      <div class="form-group col-md-6">
                                        <textarea class="form-control form-control-sm" rows="2" placeholder="Description" v-model="formup.description"></textarea>
                                      </div>
                                    </div>
                                    <button type="submit" class="btn btn-info btn-sm">Update</button>
                                    <a href="#" @click.prevent="tagindex = -1" class="btn btn-info btn-sm">Cancel</a>

                                </form>

                              </td>
                            </tr>


                          </tbody></table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
            </div>

          </div>
      </div>
  </section>
</template>
<script>
export default{
  name: "tags",
  data(){
      return{
        tagindex:-1,
        tagsp:{},
        form: new Form({
              tagname:'',
              slug:'',
              description:'',
        }),
        formup: new Form({
            name:'',
            slug:'',
            description:'',
        })
      }
  },
  mounted(){
      this.$store.dispatch('getAllTags')
  },
  computed:{
      alltags(){
          return this.$store.getters.getAllTags
      },
      getTagObject(){
        return this.$store.getters.getTagOb
      }
  },
  methods:{
    updateTag(id){
      if(this.formup.slug === null || this.formup.slug.match(/^ *$/) !== null){
        this.formup.slug = this.formup.name.replace(/\s+/g, '-').toLowerCase();
      }
      else {
       this.formup.slug =  this.formup.slug.toLowerCase().replace(/[^a-z0-9- ]/g, "").replace(/\s+/g, '-');
      }
      this.formup.post('/updateTag/'+id)
          .then(()=>{
              this.tagindex = -1;
              this.$store.dispatch('getAllTags')
              Toast.fire({
                  icon: 'success',
                  title: 'Tag updated successfully'
              })
          })
          .catch(()=>{
          })
    },
    showEdit(index,tag) {
      this.tagindex = index;
      this.formup.fill(tag);
    //  console.log(index);
    },

    getTags(page = 1) {
      this.$store.dispatch('getAllTags',page);

    },
    addnewTag(){
      if(this.form.slug === null || this.form.slug.match(/^ *$/) !== null){
        this.addSlug();
      }
      else {
       this.form.slug =  this.form.slug.toLowerCase().replace(/[^a-z0-9- ]/g, "").replace(/\s+/g, '-');
      }
      this.form.post('/savetag')
          .then(()=>{
            this.form.reset();
            this.$store.dispatch('getAllTags')
            Toast.fire({
                icon: 'success',
                title: 'Tag Added successfully'
            })
          }).catch(()=>{})

    },
    addSlug(){
      let slug =this.form.tagname;
      slug = slug.replace(/\s+/g, '-').toLowerCase();
      this.form.slug = slug;
    },
    deletetag(id){
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
          axios.get('/deletetag/'+id).then(()=>{
            Swal.fire(
              'Deleted!',
              'Your tag has been deleted.',
              'success'
            )
            this.$store.dispatch('getAllTags')
          }).catch(()=>{
             swal("Failed!", "There was something wronge.", "warning");
          });
        }
      })
    },//del tag
  },
}
</script>
