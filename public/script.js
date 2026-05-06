

$(document).ready(function(){

    let ad = $("#advertisement");

    $("#openAd").click(function(){
        ad.slideDown();
    });

    $("#hideAd").click(function(){
        ad.hide();
    });

    $("#showAd").click(function(){
        ad.show();
    });

    $("#fadeInAd").click(function(){
        ad.fadeIn(2000);
    });

    $("#fadeOutAd").click(function(){
        ad.fadeOut("slow");
    });

    $("#fadeToAd").click(function(){
        $("#img").fadeTo("fast", 0.7);
        $("#text").fadeTo("slow", 0.5);
    });

    $("#slideUpAd").click(function(){
        ad.slideUp();
    });

    $("#slideDownAd").click(function(){
        ad.slideDown("slow");
    });

    $("#animateAd").click(function(){
        ad.animate({
            padding: "80px",
            opacity: 0.8
        }, 3000);
    });

    $("#stopAd").click(function(){
        ad.stop();
    });


    // Charts

    new Chart(document.getElementById('bar'), {
        type: 'bar',
        data: {
            labels: ['Oct', 'Nov', 'Dec', 'Jan', 'Feb'],
            datasets: [{
                label: 'Books Sold',
                data: [120, 190, 300, 250, 220],
                backgroundColor: 'rgba(54, 11, 235, 0.6)'
            }]
        }
        
    });

    new Chart(document.getElementById('pie'), {
        type: 'pie',
        data: {
            labels: ['Fiction', 'Science', 'History', 'Fantasy'],
            datasets: [{
                data: [35, 15, 20, 30],
                backgroundColor: [
                    '#ff6384',
                    '#36a2eb',
                    '#ffce56',
                    '#4bc0c0'
                ]
            }]
        }
    });

    new Chart(document.getElementById('line'), {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Website Visitors',
                data: [500, 700, 900, 1200],
                borderColor: '#ff5722',
                fill: false,
                tension: 0.3
            }]
        }
    });

    new Chart(document.getElementById('polar'), {
        type: 'polarArea',
        data: {
            labels: ['Martin Eden', 'The Stranger', '1984', 'The Process', 'Frankenstein'],
            datasets: [{
                data: [13, 14, 7, 11, 16],
                backgroundColor: [
                    '#ff6384',
                    '#36a2eb',
                    '#ffce56',
                    '#4bc0c0',
                    '#9966ff'
                ]
            }]
        }
    });

});

function handleRegister() {
        const login = document.getElementById('login').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        const errorMsg = document.getElementById('errorMsg');
        const successMsg = document.getElementById('successMsg');

        errorMsg.classList.add('d-none');
        successMsg.classList.add('d-none');

        if (!login || !email || !password || !confirmPassword) {
            errorMsg.textContent = 'Please fill in all fields.';
            errorMsg.classList.remove('d-none');
            return;
        }

        if (password !== confirmPassword) {
            errorMsg.textContent = 'Passwords do not match.';
            errorMsg.classList.remove('d-none');
            return;
        }

        document.getElementById('registerForm').classList.add('d-none');
        successMsg.classList.remove('d-none');
    }

fetch('/api/books')
  .then(res => res.json())
  .then(data => console.log(data));