const API =
  "https://voyage-vista-production.up.railway.app";

async function login(email, password) {

  const response = await fetch(
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
  }

  return data;
}
