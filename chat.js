const API_URL = "https://voyage-vista-production.up.railway.app/api/chat.php";

function addMessage(text, type) {
  const box = document.getElementById("chat-box");

  const div = document.createElement("div");
  div.classList.add("msg", type);
  div.textContent = text;

  box.appendChild(div);
  box.scrollTop = box.scrollHeight;

  return div;
}

/* Loader typing bubble */
function addTyping() {
  const box = document.getElementById("chat-box");

  const div = document.createElement("div");
  div.classList.add("msg", "bot");

  div.innerHTML = `
    <div class="typing">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
  `;

  box.appendChild(div);
  box.scrollTop = box.scrollHeight;

  return div;
}

async function sendMessage() {
  const input = document.getElementById("user-input");
  const text = input.value.trim();

  if (!text) return;

  // message user
  addMessage(text, "user");
  input.value = "";

  // loader bot
  const loader = addTyping();

  try {
    const res = await fetch(API_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ message: text })
    });

    const data = await res.json();

    // remove loader
    loader.remove();

    // bot response
    addMessage(data.reply || "Erreur API", "bot");

  } catch (e) {
    loader.remove();
    addMessage("Erreur serveur", "bot");
  }
}

document.getElementById("user-input").addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    event.preventDefault(); // évite retour à la ligne / comportement bizarre
    sendMessage();
  }
});
