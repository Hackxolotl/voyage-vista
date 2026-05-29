const API_URL = "https://voyage-vista-production.up.railway.app/api/chat.php";

async function sendMessage() {
  const input = document.getElementById("user-input");
  const text = input.value.trim();

  if (!text) return;

  addMessage(text, "user-msg");
  input.value = "";

  const res = await fetch(API_URL, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ message: text })
  });

  const data = await res.json();

  addMessage(data.reply || "Erreur serveur", "bot-msg");
}

function addMessage(text, className) {
  const box = document.getElementById("chat-box");

  const div = document.createElement("div");
  div.className = className;
  div.textContent = text;

  box.appendChild(div);
  box.scrollTop = box.scrollHeight;
}
