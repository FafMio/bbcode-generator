let covers = document.querySelectorAll('img[data-cover]');
let coverRendered = document.querySelector('img[data-rendered-cover]');
let coverForm = document.querySelector('input[type="hidden"][name="cover_url"]')

covers.forEach((cover) => {
    cover.addEventListener('click', (e) => {
        coverRendered.src = cover.src;
        coverForm.value = cover.src;
    })
})