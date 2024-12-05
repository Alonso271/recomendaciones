document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('showFormBtn').addEventListener('click', function() {
            var form = document.getElementById('reviewForm');
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        });
    });


