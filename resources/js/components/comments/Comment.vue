<style>
.comment-area{
  margin-top: 10px;
}
.media{
  margin-bottom: 0px
}
.media-content{
  border-bottom: none;
padding-bottom: 10px;
}
.media .media{
  margin-top: 10px;
}
.media-content h6{
  margin-bottom: 5px
}
.media-content .fmedia{
  padding-left: 20px;
}
.comment-area .thumbnail > img{
  width: 40px;
}
.comment-area .thumb-reply > img{
width: 26px;
}
.reply-input{
  border-radius: 10px !important;
  width: 70%;
  margin-left: 5px;
  height: 25px !important;
}
.reply-area{
  margin-top: 7px;
}
.child-comment .thumbnail>img{
  width: 26px
}
.comment-area .child-comment, .child-comment .media .media{
  margin: 0px;
}
.child-comment .media-content {
  margin-left: 2px;
  font-size: 13px;
}
.child-comment h6,
.child-comment span{
  font-size: 13px
}
.child-comment button{
  font-size: 9px
}
.child-comment .reply-input{
  width: 58%
}
.child-comment p{
  margin: 0 0 2px;
}
</style>
<template>
  <div class="comment-area" :class="{ 'child-comment': comment.parent_id !=null }">
                <div class="media">
                  <a href="#" class="thumbnail pull-left"><img src="img/avatar.png" alt=""></a>
                  <div class="media-body">
                    <div class="media-content">
                      <h6> {{ comment.user.name }}<span>&nbsp;&nbsp; at &nbsp;{{comment.created_at |timeformat}}</span></h6>

                      <div v-if="commentArea"><p>
                          {{ comment.content |sortlength(50,"...") }} <!-- -{{comlevel}} -->
                        </p>
                        <span v-if="comlevel < 3"><a class="reply" @click="replyToComment = comment">Reply</a> </span>
                        <span v-if="isCurrentUser(comment.user.id)"><i class="fa fa-user blue" @click="editComment(comment)"></i>
                          <i class="fa fa-trash red"></i></span>
                      </div>
                      <div v-if="commentEdit">
                        <textarea type="text" class="form-control reply-input">{{comment.content}}</textarea>
                        <button type="submit" class="btn btn-primary">Edit</button>
                      </div>

                      <form @submit.prevent="replyTo(comment)">
                      <div class="reply-area" v-if="replyToComment == comment">
                        <a href="#" class="thumbnail pull-left thumb-reply"><img src="img/avatar.png" alt=""></a>
                       <textarea type="text" class="form-control reply-input" v-model="replyContent"></textarea>
                       <button type="submit" class="btn btn-primary">Send</button>
                      </div></form>

                      <span v-if="collection[comment.id] && showtext"><a class="view" @click="showTheComments()">View more <span v-if="comment.parent_id==null">( {{countArray(collection['root'])}} )</span> ...</a></span>
                      <span v-if="collection[comment.id] && !showtext"><a class="view" @click="hideTheComments()">View less ...</a></span>
                      <comment-list v-if="collection[comment.id] && viewAllComment" :comments="collection[comment.id]" :level="comlevel" :collection="collection"></comment-list>
                    </div>
                  </div>
                </div>
  </div>
</template>

<script>
    import CommentList from './CommentList.vue';
    export default {
      props: ['collection','comment','level'],
        name: "comment",
        data(){
            return {
                replyToComment: false,
                replyContent:'',
                ischild:true,
                commentArea:true,
                commentEdit: false,
                comlevel: this.level,
                showtext: true,
                viewAllComment: false ,

            }
        },
        methods:{
          isCurrentUser(userId){
            return this.$userId == userId
          },
          countArray(collection){
            return collection.length;
          },
          editComment(comment){
            this.commentArea = false;
            this.commentEdit = true;
          },
          showTheComments(){
            this.viewAllComment = true;
            this.showtext = false;
//this.$root.$emit('view', 1 );
          },
          hideTheComments(){
            this.viewAllComment = false;
            this.showtext = true;
          },
           replyTo(comment){
               axios.post('/replycomment', {replyContent: this.replyContent, post_id: comment.post_id, parent_id: comment.id})
               .then(response => {
                  this.replyContent = '';

           });
           }
       },
        mounted(){

        },
        created(){
          this.comlevel++;
          //console.log(this.$userId);
          //this.$root.$on('view', (val) => {
            //  this.viewAllComment = val;
          //})

        },
        components: {
            'comment-list': CommentList,
        },
  }
</script>
