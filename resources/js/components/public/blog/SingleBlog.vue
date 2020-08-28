<template>
    <span id="singleblog">
        <section id="content">
      <div class="container">
        <div class="row">
          <div class="span8">
            <article>
              <div class="row">
                <div class="span8">
                  <div class="post-image">
                    <div class="post-heading">
                      <h3><a href="#"> {{singlepost.title}}</a></h3>

                    </div>
                    <img :src="`uploadimage/${singlepost.photo}`" alt="" />
                  </div>
                  <p>
                   {{singlepost.description}}
                  </p>

                  <div class="bottom-article">
                    <ul class="meta-post">
                      <li v-if="singlepost.user"><i class="icon-user"></i><a href="#"> {{singlepost.user.name}}</a></li>
                      <li v-if="singlepost.category"><i class="icon-folder-open"></i><a href="#"> {{singlepost.category.cat_name}}</a></li>

                    </ul>
                  </div>
                </div>
              </div>
            </article>
            <a herf="#" v-if="loadVisible" @click="loadEvent()"> Load more ..</a> <!--:comments="singlepost.comments.root"-->
            <CommentList  v-if="singlepost.comments" :collection="singlepost.comments" :level="0" :comments="commentToLoad"></CommentList>
            <h4>Leave your comment</h4>
            <form id="commentform" action="#" method="post" name="comment-form">
              <div class="row">
                <div class="span4">
                  <input type="text" placeholder="* Enter your full name">
                </div>
                <div class="span4">
                  <input type="text" placeholder="* Enter your email address">
                </div>
                <div class="span4 margintop10">
                  <input type="text" placeholder="Enter your website">
                </div>
                <div class="span8 margintop10">
                  <p>
                    <textarea rows="12" class="input-block-level" placeholder="*Your comment here"></textarea>
                  </p>
                  <p>
                    <button class="btn btn-theme margintop10" type="submit">Submit comment</button>
                  </p>
                </div>
              </div>
            </form>

          </div>
            <BlogSidebar/>
        </div>
      </div>
    </section>
    </span>
</template>

<script>
    import BlogSidebar from "./BlogSidebar.vue"
    import CommentList from "../../comments/CommentList.vue"
    import { mapState } from 'vuex'

    export default {
        name: "SingleBlog",
        components:{
            BlogSidebar,
            CommentList
        },
        data(){
            return {
                commentToShow: 2,
                loadVisible: true,
                commentToLoad :[],
                counter:0,
            }
        },
        computed:{
          ...mapState([
            'rootcomments'
          ]),
            singlepost(){
                return this.$store.getters.singlepost
            },

        },
        methods:{
          loadEvent(){
            let comment = this.rootcomments;
            this.commentToShow +=2;
              for( this.counter ; this.counter< comment.length && this.counter < this.commentToShow ;this.counter++){
                this.commentToLoad.push(comment[this.counter]);
              }

          },
          loadMore(){
            const comment = this.rootcomments;
            const commentLimit = this.commentToShow ;
            const result= this.commentToLoad;

            let count = this.counter;

              for( count ; count < comment.length && count < commentLimit ; count++){
                result.push(comment[count]);
                console.log(count +' '+ commentLimit);
              }
              this.counter = count;
              this.commentToShow = commentLimit ;
              this.commentToLoad = result;

          },
            singlePost(){
                this.$store.dispatch('getPostById',this.$route.params.id);
            }
        },
        mounted(){
            this.singlePost();
        },
        created(){
      //    this.loadMore();

        },
        updated(){
          this.loadMore();
        },
        watch:{
            $route(to,from){
                this.singlePost();
            },
            commentToLoad(){

          },

        }
    }
</script>
