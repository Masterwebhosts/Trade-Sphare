<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>أعلاني | منصة إعلانية متكاملة</title>

<!-- PWA -->
<link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>">
<meta name="theme-color" content="#0066ff">
<link rel="apple-touch-icon" href="<?php echo e(asset('icons/icon-192.png')); ?>">


<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:Tahoma, Arial, sans-serif;
    min-height:100vh;
    overflow:hidden;
    color:#fff;

}


.bg{

    position:fixed;
    inset:0;

    background:linear-gradient(
        -45deg,
        #0f172a,
        #1e293b,
        #111827,
        #0b1220
    );

    background-size:400% 400%;
    animation:bgMove 15s ease infinite;

    z-index:-2;

}



@keyframes bgMove{

    0%{
        background-position:0% 50%;
    }

    50%{
        background-position:100% 50%;
    }

    100%{
        background-position:0% 50%;
    }

}



.particle{

    position:absolute;
    width:5px;
    height:5px;

    border-radius:50%;

    background:rgba(255,255,255,.15);

    animation:float linear infinite;

}



@keyframes float{

    from{

        transform:translateY(100vh);
        opacity:0;

    }


    20%{

        opacity:1;

    }


    to{

        transform:translateY(-10vh);
        opacity:0;

    }

}



.container{

    max-width:1000px;
    margin:auto;

    padding:50px 20px;

    text-align:center;

}



.logo-image{

    width:320px;
    max-width:90%;

    height:auto;

    display:block;

    margin:0 auto 20px;

    filter:drop-shadow(0 15px 30px rgba(0,0,0,.4));

}



.badge-brand{

    display:inline-block;

    padding:8px 18px;

    border-radius:999px;

    background:rgba(59,130,246,.12);

    border:1px solid rgba(59,130,246,.25);

    color:#93c5fd;

    font-size:12px;

    letter-spacing:2px;

    margin-bottom:25px;

}



.subtitle{

    max-width:750px;

    margin:auto;

    color:#cbd5e1;

    line-height:1.9;

    font-size:18px;

    margin-bottom:35px;

}



.card{

    background:rgba(255,255,255,.08);

    backdrop-filter:blur(16px);

    border:1px solid rgba(255,255,255,.08);

    border-radius:20px;

    padding:35px;

    box-shadow:0 20px 50px rgba(0,0,0,.35);

}



.welcome{

    font-size:26px;

    font-weight:bold;

    margin-bottom:15px;

}



.description{

    color:#dbe4ee;

    line-height:1.9;

    margin-bottom:20px;

}



.user-badge{

    display:inline-block;

    padding:8px 14px;

    border-radius:999px;

    background:rgba(16,185,129,.15);

    border:1px solid rgba(16,185,129,.25);

    color:#a7f3d0;

    font-size:13px;

    margin-bottom:20px;

}



.links{

    display:flex;

    justify-content:center;

    flex-wrap:wrap;

    gap:15px;

    margin-top:20px;

}



.button{

    text-decoration:none;

    color:#fff;

    padding:14px 24px;

    border-radius:12px;

    font-weight:bold;

    transition:.3s;

}



.primary{

    background:linear-gradient(135deg,#2563eb,#3b82f6);

}



.primary:hover{

    transform:translateY(-2px);

}



.secondary{

    background:rgba(255,255,255,.08);

    border:1px solid rgba(255,255,255,.15);

}



.secondary:hover{

    background:rgba(255,255,255,.15);

}



.logout{

    background:rgba(220,38,38,.25);

    border:1px solid rgba(220,38,38,.35);

}



.footer{

    margin-top:25px;

    color:#94a3b8;

    font-size:13px;

}



@media(max-width:768px){


    .logo-image{

        width:220px;

    }


    .subtitle{

        font-size:16px;

    }


    .button{

        width:100%;

    }


    .card{

        padding:25px;

    }


}


</style>

</head>


<body>


<div class="bg"></div>


<script>

for(let i=0;i<30;i++){

    let p=document.createElement('div');

    p.className='particle';

    p.style.left=Math.random()*100+'vw';

    p.style.animationDuration=(5+Math.random()*10)+'s';

    document.body.appendChild(p);

}

</script>



<div class="container">


<a href="<?php echo e(url('/')); ?>">

<img

src="<?php echo e(asset('assets/images/logo.png')); ?>"

alt="أعلاني"

class="logo-image">

</a>



<div class="badge-brand">

ADVERTISING PLATFORM

</div>



<div class="subtitle">

منصة إعلانية متكاملة تساعد الشركات والأفراد في سوريا على إدارة الحملات الإعلانية والوصول إلى العملاء ومتابعة الأداء والإيرادات من مكان واحد.

</div>



<div class="card">


<?php if(auth()->guard()->check()): ?>


<div class="welcome">

مرحباً <?php echo e(auth()->user()->name); ?>


</div>


<div class="user-badge">

<?php echo e(auth()->user()->role ?? 'مستخدم'); ?>


</div>


<div class="description">

يمكنك الآن إدارة الحملات والإعلانات ومتابعة الأداء من لوحة التحكم.

</div>


<div class="links">


<a href="/dashboard" class="button primary">

لوحة التحكم

</a>



<a href="/logout"

class="button logout"

onclick="event.preventDefault();document.getElementById('logout-form').submit();">

تسجيل الخروج

</a>


</div>



<form id="logout-form"

action="/logout"

method="POST"

style="display:none;">

<?php echo csrf_field(); ?>

</form>



<?php else: ?>



<div class="welcome">

ابدأ الإعلان والوصول إلى عملائك

</div>


<div class="description">

سجّل الدخول للوصول إلى حسابك أو أنشئ حساباً جديداً للبدء بإدارة حملاتك الإعلانية.

</div>


<div class="links">


<a href="/login" class="button primary">

تسجيل الدخول

</a>



<a href="/register" class="button secondary">

إنشاء حساب جديد

</a>


</div>


<?php endif; ?>


</div>


<div class="footer">

© <?php echo e(date('Y')); ?> أعلاني - جميع الحقوق محفوظة

</div>


</div>

<!-- واتساب -->

<div class="wa-box" id="waBox">


<div class="wa-header">

مرحباً بك 👋

</div>


<div class="wa-message">

أهلاً بك في أعلاني<br>

كيف يمكننا مساعدتك؟

</div>



<a href="https://tradesphare.com/pages/info" class="wa-option">

📚 مركز المساعدة

</a>



<a href="https://wa.me/96179168899"

target="_blank"

class="wa-option">

💬 تواصل واتساب

</a>


</div>




<!-- زر واتساب العائم -->

<button class="wa-button" onclick="toggleWA()">

💬

</button>


<style>


/* واتساب */

.wa-button{


position:fixed;

bottom:20px;

right:20px;


width:45px;

height:45px;


border-radius:50%;

border:0;


background:#25D366;

color:white;


font-size:22px;


cursor:pointer;


box-shadow:0 4px 15px rgba(0,0,0,.25);


z-index:9999;


}





.wa-box{


position:fixed;


bottom:80px;


right:20px;


width:290px;


background:#fff;


border-radius:15px;


box-shadow:0 5px 25px rgba(0,0,0,.25);


overflow:hidden;


display:none;


z-index:9999;


direction:rtl;


font-family:Arial,sans-serif;


}




.wa-header{


background:#25D366;


color:white;


padding:15px;


font-size:18px;


font-weight:bold;


}




.wa-message{


padding:15px;


color:#333;


line-height:1.7;


}




.wa-option{


display:block;


margin:10px;


padding:12px;


text-align:center;


background:#f5f5f5;


border-radius:10px;


color:#222;


text-decoration:none;


transition:.3s;


}



.wa-option:hover{


background:#25D366;


color:#fff;


}




@media(max-width:600px){


.floating-download{


left:15px;

bottom:15px;

padding:10px 14px;

font-size:12px;


}



.wa-button{


right:15px;

bottom:15px;


width:40px;

height:40px;


font-size:20px;


}



.wa-box{


right:15px;

bottom:70px;

width:270px;


}


}



</style>





<script>


/* تسجيل Service Worker */

if('serviceWorker' in navigator){

navigator.serviceWorker.register('/serviceworker.js')

.then(()=>{

console.log('PWA Ready');

});

}


/* واتساب */


function toggleWA(){


let box=document.getElementById("waBox");


if(box.style.display==="block"){


box.style.display="none";


}else{


box.style.display="block";


}


}





document.addEventListener("click",function(e){


let box=document.getElementById("waBox");

let btn=document.querySelector(".wa-button");



if(!box.contains(e.target) && !btn.contains(e.target)){


box.style.display="none";


}



});



</script>



</body>

</html><?php /**PATH C:\Projects\Sham-Ads\resources\views/welcome.blade.php ENDPATH**/ ?>