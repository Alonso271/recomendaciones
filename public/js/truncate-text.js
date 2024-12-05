document.addEventListener("DOMContentLoaded", function() {
    const maxLength = 150;

    const textContainers = document.querySelectorAll('.text-to-truncate');
    
    textContainers.forEach(function(textElement) {
        const fullText = textElement.innerHTML.trim();
        const link = textElement.nextElementSibling;

        if (fullText.length > maxLength) {
            const truncatedText = fullText.substring(0, maxLength) + "...";
            textElement.innerHTML = truncatedText;
            link.style.display = 'inline';
        } else {
            link.style.display = 'none';
        }
    });
});

