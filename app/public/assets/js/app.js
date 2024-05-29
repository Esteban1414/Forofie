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
          html = this.mainPostHtmlBuilder(lastPosts[0]);
        }
        this.lp.html(html);
      })
      .catch((err) => {
        console.error("Error", err);
      });
  },

  mainPostHtmlBuilder: function (post) {
    return `
    <div class="w-100 p-4 shadow rounded bg-body">
    <h5 class="mb-1">${post.title}</h5>
    <small class="text-muted">${post.fecha} | ${post.name}</small>
    <p class="py-3 border-bottom lh-sm fs-5 mb-0" style="text-align: justify">
        ${post.body}
    </p>
    <a href="#" class="btn btn-link btn-sm text-decoration-none ${!app.user.sv ? "disabled" : ""}" onclick="app.toggleLike(event, ${post.id}, ${app.user.id})">
        <i id="iLikeHand" class="bi bi-hand-thumbs-up${
          post.liked ? "-fill" : ""
        }"></i>
        <span id="likes" class="fw-bold">${post.tt} ${post.liked ? ' Te gusta ' : ''}</span>
    </a>
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
};
