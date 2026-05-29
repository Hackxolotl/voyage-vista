const API_URL = "https://voyage-vista-production.up.railway.app/api/packages.php";

const container = document.getElementById("packages");
const loading = document.getElementById("loading");

async function loadPackages() {
  try {
    const res = await fetch(API_URL);
    const data = await res.json();

    if (!data.success) {
      throw new Error(data.error || "API error");
    }

    loading.style.display = "none";

    data.data.forEach(pkg => {
      const card = document.createElement("div");
      card.className = "card";

      card.innerHTML = `
        <h3>${pkg.nom}</h3>
        <p>📍 ${pkg.region} - ${pkg.country}</p>
        <p class="price">${pkg.price} €</p>
      `;

      container.appendChild(card);
    });

  } catch (err) {
    loading.innerText = "Erreur de chargement des données ❌";
    console.error(err);
  }
}

loadPackages();
