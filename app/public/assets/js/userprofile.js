userprofile = {
    routes: {
      updateUser: "/User/update",
  
    },
    updateUser: function () {
      const rf = $("#userForm");
      rf.on("submit", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("<input>")
        .attr("type", "hidden")
        .attr("name", "userId")
        .val(app.user.id)
        .appendTo(rf);
        const data = new FormData(this);
        fetch(userprofile.routes.updateUser, {
          method: "POST",
          body: data,
        })
          .then((res) => res.json())
          .then((res) => {
            if (res.r !== false) {
              location.href = "/Session/logout";
            } else {
              $("#error").removeClass("d-none");
            }
          })
          .catch((err) => {
            $("#error").removeClass("d-none");
          });
      });
    },
  };
  