document.addEventListener('DOMContentLoaded', function () {
  var botao = document.getElementById('botao');
  botao.addEventListener('click', function () {
    chrome.tabs.executeScript({file: "popup.js"}, function () {
      if (chrome.runtime.lastError) {
        console.error("O script falhou " + chrome.runtime.lastError.message);
      }
    });
  });
});

