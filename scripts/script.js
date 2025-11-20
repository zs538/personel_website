document.getElementById('blog').addEventListener('click', function(event) {
    event.preventDefault();
    if (Math.random() < 0.75) {
        window.location.href = '/ukolydoskoly';
    } else {
        window.location.href = 'https://www.term.io/';
    }
});