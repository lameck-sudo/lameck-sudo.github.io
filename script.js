function openProject(title, desc) {
  document.getElementById("modal-title").innerText = title;
  document.getElementById("modal-desc").innerText = desc;
  document.getElementById("modal").classList.remove("hidden");
}

function closeModal() {
  document.getElementById("modal").classList.add("hidden");
}

function toggleSettings() {
  document.getElementById("settings").classList.toggle("hidden");
}

function changeTheme(theme) {
  document.body.style.background = theme === "dark" ? "#111" : "#f4f4f4";
}

function changeLanguage(lang) {
  alert("Language switched to " + lang);
}
