function getTotal()
{

}

let subButton = document.querySelector('#add');
let addButton = document.querySelector('#sub');
let input = document.querySelector('input');

subButton.addEventListener('click', () => {
    input.value = parseInt(input.value) -1;
});

addButton.addEventListener('click', () => {
    input.value = parseInt(input.value) +1;
});