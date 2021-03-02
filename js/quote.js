// Initialise some basic needed variables
var rooms = 5;
var people = 2;
var loaction = "Bedfordshire";
var price = 1.99;

// When the page is loaded, update the price to populate the estimate data
document.onload = function(){
    getPrice(rooms, people, loaction);
};

// Get the estimate and select objects
var estimate = document.getElementById("estimate-amount");
const selectElement = document.querySelector('#location');

// Get the rooms slider and it's "number of rooms" output
var roomsSlider = document.getElementById("rooms");
var roomsOutput = document.getElementById("roomNumber");
roomsOutput.innerHTML = roomsSlider.value;

// Whenever the slider is moved, update the output and generate a new price
roomsSlider.oninput = function() {
    roomsOutput.innerHTML = this.value;
    rooms = this.value;
    getPrice(rooms, people, loaction);
}

// Get the residents slider and it's "number of residents" output
var peopleSlider = document.getElementById("residents");
var peopleOutput = document.getElementById("residentsNumber");
peopleOutput.innerHTML = peopleSlider.value;

// Whenever the slider is moved, update the output and generate a new price
peopleSlider.oninput = function() {
    peopleOutput.innerHTML = this.value;
    people = this.value;
    getPrice(rooms, people, loaction);
}

// Whenever a new location selection is made generate a new price
selectElement.addEventListener('change', (event) => {
    loaction = selectElement.value;
    getPrice(rooms, people, loaction);
});

// Get the price estimate based on the number of rooms, people and location
// Spits out some believable arbitrary number, no real value of course
// Returns a rounded price to 2 decimal places for currency formatting i.e: 12.34
function getPrice(rooms, people, location) {
    price = Math.round((((rooms * 4.39) * people) + location.length / 2) * 100) / 100;
    estimate.innerHTML = "Your Estimate: <span class='price'>£" + price + "</span> Per Month";
    return price;
}