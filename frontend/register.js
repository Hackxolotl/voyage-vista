const API =
  "https://voyage-vista-production.up.railway.app";

const form =
  document.getElementById("registerForm");

const message =
  document.getElementById("message");

form.addEventListener(
  "submit",
  async (e) => {

    e.preventDefault();

    const user = {
      nom:
        document.getElementById("nom").value,

      prenom:
        document.getElementById("prenom").value,

      email:
        document.getElementById("email").value,

      password:
        document.getElementById("password").value,

      est_etudiant:
        document.getElementById("etudiant").checked
    };

    try {

      const response =
        await fetch(
          `${API}/api/register.php`,
          {
            method: "POST",

            headers: {
              "Content-Type":
                "application/json"
            },

            body: JSON.stringify(user)
          }
        );

      const data =
        await response.json();

      if (data.success) {

        message.textContent =
          "Compte créé";

        form.reset();

      } else {

        message.textContent =
          data.message;
      }

    } catch {

      message.textContent =
        "Erreur serveur";
    }
  }
);
