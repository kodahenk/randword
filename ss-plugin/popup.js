document.getElementById("takeScreenshot").addEventListener("click", () => {
    const className = "pr entry-body"; // Hedef sınıf

    chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
        chrome.tabs.sendMessage(tabs[0].id, {
            action: "screenshot",
            className: className,
            url: tabs[0].url // URL'yi mesaj ile birlikte gönder
        });
    });
});
