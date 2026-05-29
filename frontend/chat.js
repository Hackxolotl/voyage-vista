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
  const chatBox = document.getElementById("chat-box");

  const message = input.value.trim();

  if (!message) return;

  // ======================
  // USER MESSAGE
  // ======================

  const userMsg = document.createElement("div");
  userMsg.className = "user-msg";
  userMsg.textContent = message;

  chatBox.appendChild(userMsg);

  input.value = "";

  // ======================
  // API CALL
  // ======================

  try {

    const response = await fetch(API_URL, {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        message: message
      })
    });

    const data = await response.json();

    // ======================
    // BOT MESSAGE
    // ======================

    const botMsg = document.createElement("div");
    botMsg.className = "bot-msg";

    // ✅ RENDU MARKDOWN
    botMsg.innerHTML = marked.parse(data.reply);

    chatBox.appendChild(botMsg);

    // auto scroll
    chatBox.scrollTop = chatBox.scrollHeight;

  } catch (err) {

    const errorMsg = document.createElement("div");
    errorMsg.className = "bot-msg";
    errorMsg.textContent = "Erreur serveur.";

    chatBox.appendChild(errorMsg);
  }
}

document.getElementById("user-input").addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    event.preventDefault(); // évite retour à la ligne / comportement bizarre
    sendMessage();
  }
});
