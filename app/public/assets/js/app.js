const app = {
  routes: {
    /* Views */
    home: "/home",
    inisession: "/Session/iniSession",

    /* Controllers */
    login: "/Session/userAuth",
    register: "/Register/register",
    prevposts: "/Posts/getPosts",
    lastposts: "/Posts/getLastPost",
    toggleLike: "/Posts/toggleLike",
    postcomments: "/Posts/getComments",
    savecomment : "/Posts/saveComment",

  },

  user: {
    sv: false,
    id: "",
    name: "",
    tipo: "",
  },

  pp: $("#prev-posts"),
  lp: $("#last-posts"),

  previousPosts: function () {
    let html = `<b>Aún no hay publicaciones</b>`;
    this.pp.html("");
    fetch(this.routes.prevposts)
      .then((res) => res.json())
      .then((posts) => {
        html = "";
        for (let post of posts) {
          html += `
                    <button onclick="app.openPost(${post.id})"
                        class="list-group-item list-group-item-action">
                        <div class="w-100 border-bottom">
                            <span class="mb-1">${post.title}</span>
                            <small>
                                ${post.fecha}
                            </small>
                        </div>
                        <small>
                            <b>${post.name}</b>
                        </small>
                    </button>
                `;
        }
        this.pp.html(html);
      })
      .catch((err) => {
        console.error("Error", err);
      });
  },

  lastPost: function () {
    let html = "<b>Aún no hay publicaciones</b>";
    this.lp.html("");
    fetch(this.routes.lastposts)
      .then((res) => res.json())
      .then((lastPosts) => {
        if (lastPosts.length > 0) {
          html = this.mainPostHtmlBuilder(lastPosts);
        }
        this.lp.html(html);
      })
      .catch((err) => {
        console.error("Error", err);
      });
  },

  mainPostHtmlBuilder : function(post){
        return `
                <div class="w-100 p-4 shadow rounded bg-body">
                    <h5 class="mb-1">${ post[0].title }</h5>
                    <small class="text-muted">
                        <i class="bi bi-calendar-week"></i> ${ post[0].fecha } | 
                        <i class="bi bi-person-circle"></i> ${ post[0].name }
                    </small>
                    <p class="py-3 border-bottom fs-5 lh-sm mb-0" style="text-align:justify;">
                        ${ post[0].body }
                    </p>

                    <a href="#" class="btn btn-link btn-sm text-decoration-none  ${ !app.user.sv ? 'disabled' : '' }"
                        onclick="app.toggleLike(event,${ post[0].id },${ app.user.id })">
                        <i class="bi bi-hand-thumbs-up${ post[1].liked ? '-fill':'' }" id="iLikeHand"></i> <span id="likes" class="fw-bold">${ post[1].tt } ${ post[1].liked ? ' - Te gusta' : '' } </span> 
                    </a>
                    
                    <span id="comentarios" class="float-end fw-bolder">
                        <small>
                            <a href="#" onclick="app.toggleComments(event,${ post[0].id },'#post-comments')" id="view-comments"
                                class="btn btn-link btn-sm text-decoration-none ${ post[2].tt > 0 ? '' : 'disabled' } link-secondary" rol="button">
                                <i class="bi bi-chat-left-text"></i>
                                <span id="tt-comments">${ post[2].tt }</span> comentarios
                            </a>
                        </small>
                    </span>
                    <div class="input-group mb-3">
                        <input type="text" name="comment" id="comment"
                            class="form-control rounded-5 bg-body-secondary"  ${ !app.user.sv ? 'disabled readonly' : ''}
                            placeholder="${ app.user.sv ? 'Deja tu comentario' : 'Registrate para poder hacer comentarios'}">
                        <button class="btn btn-outline-primary rounded-5 border border-light " type="button" id="btn-comment-send" 
                            ${ !app.user.sv ? 'disabled' : ''}
                            onclick="app.saveComment(${ post[0].id })">
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                    <div class="container mb-2 small-font">
                        <ul class="list-group d-none" id="post-comments">                            
                        </ul>                        
                    </div>

                </div>
            `;
    },
  
  toggleLike: function (e, pid, uid) {
    e.preventDefault();
    fetch(this.routes.toggleLike + "/" + pid + "/" + uid)
      .then((res) => res.json())
      .then((post) => {
        $("#likes").html(`${post[0].tt} ${post[0].liked ? ' Te gusta ': ''}`),
        $("#iLikeHand").toggleClass("bi bi-hand-thumbs-up-fill", post[0].liked)
        $("#iLikeHand").toggleClass("bi bi-hand-thumbs-up", !post[0].liked)
      })
      .catch((err) => {
        console.error("Error", err);
      });
  },
  toggleComments : function(e,pid,element){
    if(e){
        e.preventDefault();
        $(element).toggleClass("d-none");
    }else{
        $(element).removeClass("d-none");
    }
    fetch(this.routes.postcomments + "/" + pid)
        .then( resp => resp.json())
        .then( comments => {
            if(comments.length > 0){
                let html = '';
                for( let c of comments){
                    html += `
                        <li class="list-group-item">
                            <p class="mb-0"><span class="fw-bold">${ c.name }</span> | ${ c.fecha }</p>
                            <p class="mb-0">${ c.body }</p>                                
                        </li>
                    `;
                }
                $(element).html(html);
            }
        }).catch( err => console.error("Hay un error: ",err ))
},    
saveComment : function(pid){
    if($('#comment').val() !== ""){
        const datos = new FormData();
        datos.append('pid',pid);
        datos.append('uid',this.user.id);
        datos.append('body', $('#comment').val());
        fetch(this.routes.savecomment,{
                method:"POST",
                body: datos })
            .then( resp => resp.json() )
            .then( r  => {
                this.toggleComments(null,pid,"#post-comments");
                $('#comment').val("");
                $("#tt-comments").html(r[0].tt);
                $("#view-comments").toggleClass("disabled", !r[0].tt)
                //console.log(r[0].tt)
            }).catch( err => console.error("Hay un error: ", err ));
    }       
}

}