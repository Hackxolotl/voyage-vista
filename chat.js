function sendMessage() {
  const input = document.getElementById("user-input");
  const text = input.value.trim();
  if (!text) return;

  addMessage(text, "user-msg");
  input.value = "";

  const chatBox = document.getElementById("chat-box");

  const botDiv = document.createElement("div");
  botDiv.className = "bot-msg";
  botDiv.textContent = "";
  chatBox.appendChild(botDiv);

  const response = fetch("https://voyage-vista-production.up.railway.app/api/chat-stream.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ message: text })
  });

  let reader;

  response.then(async (res) => {
    reader = res.body.getReader();
    const decoder = new TextDecoder("utf-8");

    let fullText = "";

    while (true) {
      const { value, done } = await reader.read();
      if (done) break;

      const chunk = decoder.decode(value);
      const lines = chunk.split("\n");

      for (let line of lines) {
        if (line.startsWith("data: ")) {
          const data = line.replace("data: ", "").trim();

          if (data === "[DONE]") return;

          try {
            const json = JSON.parse(data);

            const text =
              json.candidates?.[0]?.content?.parts?.[0]?.text || "";

            fullText += text;
            botDiv.textContent = fullText;
            chatBox.scrollTop = chatBox.scrollHeight;

          } catch (e) {
            // ignore chunks incomplets
          }
        }
      }
    }
  });
}
