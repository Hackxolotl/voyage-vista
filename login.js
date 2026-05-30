const API =
  "https://voyage-vista-production.up.railway.app";

const form =
  document.getElementById("loginForm");

const message =
  document.getElementById("message");

form.addEventListener(
  "submit",
  async (e) => {

    e.preventDefault();

    const email =
      document.getElementById("email").value;

    const password =
      document.getElementById("password").value;

    try {

      const response =
        await fetch(
          `${API}/api/login.php`,
          {
            method: "POST",

            headers: {
              "Content-Type":
                "application/json"
            },

            body: JSON.stringify({
              email,
              password
            })
          }
        );

      const data =
        await response.json();

      if (data.success) {

        localStorage.setItem(
          "token",
          data.token
        );

        localStorage.setItem(
          "user",
          JSON.stringify(data.user)
        );

        message.textContent =
          "Connexion réussie";

      } else {

        message.textContent =
          data.message;
      }

    } catch (error) {

      message.textContent =
        "Erreur serveur";
    }
  }
);
