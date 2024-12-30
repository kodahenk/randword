// Ekran görüntüsü alma işlevi
function takeScreenshot(className, url) {
    const element = document.querySelector(`.${className.split(" ").join(".")}`);
    if (!element) {
        alert(`Element with class "${className}" not found.`);
        return;
    }

    // URL'nin son kısmından dosya adı oluşturma
    const fileName = url.split('/').filter(Boolean).pop(); // Son alanı al
    const sanitizedFileName = fileName.replace(/[^\w\-]/g, '_'); // Geçersiz karakterleri temizle

    element.scrollIntoView({ behavior: "smooth", block: "center" });

    html2canvas(element).then((canvas) => {
        const link = document.createElement("a");
        link.href = canvas.toDataURL("image/jpeg", 0.9); // JPEG formatında veriyi al
        link.download = `${sanitizedFileName}.jpeg`; // Dosya adını kullan
        link.click();
    }).catch((error) => {
        console.error("Screenshot failed:", error);
        alert("An error occurred while taking the screenshot.");
    });
}

// Mesaj dinleyicisi
chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
    if (message.action === "screenshot") {
        const url = message.url || window.location.href; // URL'yi al
        takeScreenshot(message.className, url); // Ekran görüntüsü işlevine geçir
    }
});
