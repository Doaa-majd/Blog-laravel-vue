export default {
    state:{
        category:[],
        post:[],
        blogpost:[],
        singlepost:[],
        allcategories:[],
        latestpost:[],
        tags:[],
        tagsob:{},
        media:[],
        rootcomments:[],
    },
    getters:{
      getRoot(state){
        return state.rootcomments
      },
      getAllMedia(state){
        return state.media
      },
        getCategory(state){
            return state.category
        },
        getAllPost(state){
            return state.post
        },
        getAllTags(state){
        //  console.log(state.tags)
          return state.tags
        },
        getTagOb(state){
          return state.tagsob
        },
        getblogPost(state){
            return state.blogpost
        },
        singlepost(state){
            return state.singlepost
        },
        allcategories(state){
            return state.allcategories
        },
        latestpost(state){
            return state.latestpost
        }

    },
    actions:{
      allMedia(context){
        axios.get('/getmedia')
            .then((response)=>{
                context.commit('mediamutation',response.data.media)
            })
      },
        allCategory(context){
            axios.get('/category')
                .then((response)=>{
                    context.commit('categoreis',response.data.categories)
                })
        },
        gelAllPost(context){
            axios.get('/post')
                .then((response)=>{
                    console.log(response.data.posts)
                    context.commit('allpost',response.data.posts)
                })
        },
        getAllTags(context, page){
            axios.get('/tags?page=' + page)
                .then((response)=>{
                    //console.log(response.data.tags)
                    context.commit('alltags',response.data.tags.data)
                    context.commit('tagobject',response.data.tags)
                })
        },
        getblogPost(context){
            axios.get('/blogpost')
                .then((response)=>{
                    // console.log(response.data)
                    context.commit('getblogPost',response.data.posts)
                })
        },
        getPostById(context,payload){
            axios.get('/singlepost/'+payload)
                .then((response)=>{
                    context.commit('siglePost',response.data.post)
                    context.commit('getrootComments',response.data.post.comments.root)
                })
        },
        allcategories(context){
            axios.get('/categories')
                .then((response)=>{

                    context.commit('allcategories',response.data.categories)
                })
        },
        getPostByCatId(context,payload){
            axios.get('/categorypost/'+payload)
                .then((response)=>{
                    console.log(response.data.posts)
                    context.commit('getPostByCatId',response.data.posts)
                })
        },
        SearchPost(context,payload){
            axios.get('/search?s='+payload)
                .then((response)=>{
                    context.commit('getSearchPost',response.data.posts)
                })

        },
        latestPost(context){
            axios.get('/latestpost')
                .then((response)=>{
                    // console.log(response.data)
                    context.commit('latestpost',response.data.posts)
                })
        }
    },
    mutations:{
      mediamutation(state,data){
        return state.media = data
      },
        categoreis(state,data){
            return state.category = data
        },
        allpost(state,payload){
            return state.post = payload
        },
        alltags(state,payload){
          return state.tags = payload
        },
        tagobject(state,payload){
          return state.tagsob = payload
        },
        getblogPost(state,payload){
            return state.blogpost = payload
        },
        getrootComments(state,payload){
          return state.rootcomments =payload
        },
        siglePost(state,payload){
            return state.singlepost = payload
        },
        allcategories(state,payload){
            return state.allcategories = payload
        },
        getPostByCatId(state,payload){
            state.blogpost = payload
        },
        getSearchPost(state,payload){
            state.blogpost = payload
        },
        latestpost(state,payload){
            state.latestpost = payload
        }


    }
}
