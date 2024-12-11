function validateForm() {
        const title = document.getElementById('title').value.trim();
        const description = document.getElementById('description').value.trim();
        
        if (title === '' || description === '') {
            alert("Por favor, completa todos los campos.");
            return false;
        }
        
        const htmlTagsRegex = /<\/?[a-z][\s\S]*>/i;
        const jsInjectionRegex = /<script.*?>.*?<\/script>/i;
        const jsAttributesRegex = /on[a-z]+\s*=\s*['"][^'"]*['"]/i;
        
        if (htmlTagsRegex.test(title) || htmlTagsRegex.test(description) || jsInjectionRegex.test(title) || jsInjectionRegex.test(description) || jsAttributesRegex.test(title) || jsAttributesRegex.test(description)) {
            alert("No se permite el uso de código HTML ni JavaScript.");
            return false;
        }
        
        return true;
    }


