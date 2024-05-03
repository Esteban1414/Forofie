const app_myposts = {
  routes: {
    /* Views */
    home: "/",

    /* Controllers */
    getMyPosts: "/Userposts/getMyPosts",
  },

  tblmp: $("#tbl-mis-publicaciones"),

  loadMyPosts: function (text_filter = "") {
    fetch(this.routes.getMyPosts + `/${app.user.id}/${text_filter}`)
      .then((res) => res.json())
      .then((posts) => {
        let: html = "";
        for (let p of posts) {
          html += `
            <tr>
                <td>${p.fecha}</td>
                <td>${p.title}</td>
            </tr>
            `;
          }
          this.tblmp.html(html);
      })
      .catch((err) => console.error("Error: ", err));
  },
};
