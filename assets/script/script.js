let typing = new Typed(".multiText", {
    strings: ['make Software', 'Inspire', 'give IT help', 'Create'],
    loop: true,
    typeSpeed: 100,
    backSpeed: 80,
    backDelay: 1500
})

document.getElementById("mainButton").onclick = function() {
    location.href = "#";
};

document.getElementById("mainButton2").onclick = function() {
    location.href = "#contact";
};