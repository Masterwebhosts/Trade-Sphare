@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">


    {{-- Navigation --}}
    <div class="bg-white rounded-xl shadow border p-4 sticky top-4 z-10">

        <div class="flex flex-wrap gap-4 text-sm">

            <a href="#about" class="hover:text-blue-600">
                من نحن
            </a>

            <a href="#work" class="hover:text-blue-600">
                كيف تعمل المنصة
            </a>

            <a href="#help" class="hover:text-blue-600">
                التعليمات
            </a>

            <a href="#contact" class="hover:text-blue-600">
                التواصل
            </a>

            <a href="#privacy" class="hover:text-blue-600">
                الخصوصية
            </a>

            <a href="#terms" class="hover:text-blue-600">
                الشروط
            </a>

        </div>

    </div>



    {{-- About --}}
    <section id="about" class="bg-white rounded-xl shadow border p-6">

        <h2 class="text-xl font-bold mb-4">
            من نحن
        </h2>

        <p class="text-gray-600 leading-8">

            شام للإعلانات هي منصة إعلانية متكاملة تربط بين
            المعلنين والناشرين بطريقة ذكية وآمنة.

            توفر المنصة إدارة الحملات الإعلانية، إنشاء الإعلانات،
            متابعة النتائج، وتحليل الأداء من خلال لوحة تحكم واحدة.

        </p>

    </section>




    {{-- How it works --}}
    <section id="work" class="bg-white rounded-xl shadow border p-6">

        <h2 class="text-xl font-bold mb-4">
            كيف تعمل المنصة
        </h2>


        <div class="space-y-3 text-gray-600">

            <p>
                1- يقوم المعلن بإنشاء حملة إعلانية وتحديد الميزانية.
            </p>

            <p>
                2- يتم إضافة الإعلانات وربطها بالمناطق الإعلانية المناسبة.
            </p>

            <p>
                3- يقوم الناشر بعرض الإعلانات داخل مواقعه أو تطبيقاته.
            </p>

            <p>
                4- يتم احتساب التفاعل والأرباح بشكل تلقائي حسب النظام.
            </p>

        </div>

    </section>




    {{-- Help --}}
    <section id="help" class="bg-white rounded-xl shadow border p-6">

        <h2 class="text-xl font-bold mb-4">
            التعليمات
        </h2>


        <ul class="text-gray-600 space-y-3">

            <li>
                • تأكد من صحة بيانات الحساب قبل استخدام الخدمات.
            </li>

            <li>
                • يجب الالتزام بسياسات الإعلانات والمحتوى المقبول.
            </li>

            <li>
                • يمكن متابعة الحملات والأرباح من لوحة التحكم.
            </li>

            <li>
                • في حال وجود مشكلة يمكنك التواصل مع فريق الدعم.

            </li>

        </ul>

    </section>





    {{-- Contact WhatsApp --}}
    <section id="contact" class="bg-white rounded-xl shadow border p-6">

        <h2 class="text-xl font-bold mb-4">
            اتصل بنا
        </h2>


        <p class="text-gray-600 mb-5">

            أرسل استفسارك وسيتم التواصل معك عبر واتساب.

        </p>



        <form
        onsubmit="sendWhatsApp(); return false;"
        class="space-y-4">


            <input
            id="name"
            type="text"
            placeholder="الاسم"
            class="w-full border rounded-lg p-3"
            required>



            <input
            id="subject"
            type="text"
            placeholder="العنوان"
            class="w-full border rounded-lg p-3"
            required>



            <input
            id="phone"
            type="text"
            placeholder="رقم التواصل"
            class="w-full border rounded-lg p-3"
            required>



            <textarea
            id="message"
            placeholder="الرسالة"
            rows="5"
            class="w-full border rounded-lg p-3"
            required></textarea>



            <button
            type="submit"
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

                إرسال عبر واتساب

            </button>


        </form>


    </section>





    {{-- Privacy --}}
    <section id="privacy" class="bg-white rounded-xl shadow border p-6">

        <h2 class="text-xl font-bold mb-4">
            سياسة الخصوصية
        </h2>

        <p class="text-gray-600 leading-8">

            نحترم خصوصية المستخدمين ونلتزم بحماية البيانات
            الشخصية وعدم استخدامها خارج نطاق تشغيل المنصة
            وتحسين الخدمات المقدمة.

        </p>

    </section>





    {{-- Terms --}}
    <section id="terms" class="bg-white rounded-xl shadow border p-6">

        <h2 class="text-xl font-bold mb-4">
            الشروط والأحكام
        </h2>

        <p class="text-gray-600 leading-8">

            باستخدامك لمنصة شام للإعلانات فإنك توافق على
            الالتزام بسياسات الاستخدام وعدم نشر أو ترويج
            أي محتوى مخالف للقوانين أو معايير المنصة.

        </p>

    </section>



</div>



<script>

function sendWhatsApp() {


    let whatsappNumber = "963XXXXXXXXX";


    let text =
`طلب تواصل جديد

الاسم:
${document.getElementById('name').value}

العنوان:
${document.getElementById('subject').value}

رقم التواصل:
${document.getElementById('phone').value}

الرسالة:
${document.getElementById('message').value}`;


    let url =
    "https://wa.me/" +
    whatsappNumber +
    "?text=" +
    encodeURIComponent(text);


    window.open(url, '_blank');

}

</script>


@endsection