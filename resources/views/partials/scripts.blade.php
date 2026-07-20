<script>

document.addEventListener("DOMContentLoaded", function(){



/* =========================
   Service Worker - PWA
========================= */


if('serviceWorker' in navigator){


    navigator.serviceWorker.register('/serviceworker.js')

    .then(()=>{

        console.log('PWA Ready');

    })

    .catch(error=>{

        console.log('Service Worker Error:', error);

    });


}





/* =========================
   Mobile Navbar
========================= */


window.toggleMenu = function(){


    let menu = document.getElementById("navLinks");


    if(!menu) return;


    menu.classList.toggle("active");


}




// إغلاق القائمة عند الضغط خارجها

document.addEventListener("click",function(e){


    let menu = document.getElementById("navLinks");

    let toggle = document.querySelector(".menu-toggle");



    if(menu && toggle){


        if(!menu.contains(e.target) && !toggle.contains(e.target)){


            menu.classList.remove("active");


        }


    }


});






/* =========================
   WhatsApp Button
========================= */


window.toggleWA = function(){


    let box = document.getElementById("waBox");


    if(!box) return;



    if(box.style.display === "block"){


        box.style.display="none";


    }else{


        box.style.display="block";


    }


}





// إغلاق واتساب عند الضغط خارجه


document.addEventListener("click",function(e){


    let box=document.getElementById("waBox");

    let btn=document.querySelector(".wa-button");



    if(box && btn){


        if(!box.contains(e.target) && !btn.contains(e.target)){


            box.style.display="none";


        }


    }


});







/* =========================
   FAQ Accordion
========================= */


document.querySelectorAll(".faq-question")

.forEach(button=>{



    button.addEventListener("click",()=>{



        let item=button.closest(".faq-item");



        document.querySelectorAll(".faq-item")

        .forEach(other=>{


            if(other !== item){


                other.classList.remove("active");


            }


        });




        item.classList.toggle("active");



    });


});


});

document.querySelectorAll("#navLinks a")
.forEach(link => {

    link.addEventListener("click", ()=>{

        let menu = document.getElementById("navLinks");

        if(menu){

            menu.classList.remove("active");

        }

    });

});

</script>