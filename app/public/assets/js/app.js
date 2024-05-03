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
                    <button onclick="app.openPost(event,${post.id}. this)"
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
          html = `
        <div class="w-100 p-4 shadow rounded bg-body">
              <h5 class="mb-1">${lastPosts[0].title}</h5>
              <small class="text-muted">${lastPosts[0].fecha} | ${lastPosts[0].name}</small>
              <p class="py-3 border-bottom lh-sm fs-5 mb-0" style="text-align: justify">
                  ${lastPosts[0].body}
              </p>
              </div>
        `;
        }
        this.lp.html(html);
      })
      .catch((err) => {
        console.error("Error", err);
      });
  },
};
