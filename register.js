async function register(user) {

  const response = await fetch(
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

  return await response.json();
}
