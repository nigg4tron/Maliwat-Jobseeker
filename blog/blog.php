<?php
    $pageTitle = "Gen";
    $intro = "Welcome to my blog:))";
    $title = "Title huh?";
    $author = "Genesis Maliwat";
    $date = "January 29, 2026";

    $start = "I’m Genesis Maliwat, a college IT student who enjoys playing mobile/pc games.";
    $mid = "In my free time, I play online games and spend time with cats.";
    $end = "My goal is to achieve financial success in life.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?= $pageTitle ?></title>
</head>

<body class="bg-gray-100 text-slate-800">

    <header class="bg-slate-700 text-white py-6 shadow">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-4xl font-bold"><?= $pageTitle ?></h1>
            <p class="text-slate-300 mt-1">Blog</p>
        </div>
    </header>

    <section class="max-w-6xl mx-auto px-4 mt-10">
        <div class="bg-gray-50 rounded-xl shadow-md overflow-hidden grid md:grid-cols-2">

            <div>
                <img 
                    src="images/catss.jpg"
                    alt="Genesis Maliwat"
                    class="w-full h-[420px] object-cover"
                >
            </div>

            <div class="p-8 flex flex-col justify-center">
                <h2 class="text-3xl font-bold text-slate-700 mb-3">
                    <?= $author ?>
                </h2>

                <p class="text-slate-600 leading-relaxed mb-4">
                    <?= $intro ?>
                </p>

                <div class="text-sm text-slate-500">
                    IT Student • Web System Technology • PHP
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 mt-10">
        <article class="bg-gray-50 rounded-xl shadow-md p-8 border border-gray-200">

            <h3 class="text-2xl font-bold text-slate-700 mb-2">
                <?= $title ?>
            </h3>

            <div class="text-sm text-slate-500 mb-6">
                Written by <span class="font-medium"><?= $author ?></span> • <?= $date ?>
            </div>
            <p class="mb-4 leading-relaxed"><?= $start ?></p>
            <p class="mb-4 leading-relaxed"><?= $mid ?></p>
            <p class="mb-4 leading-relaxed"><?= $end ?></p>

            <div class="mt-6 flex gap-2 flex-wrap">
                <span class="bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-sm">IT Student</span>
                <span class="bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-sm">PHP</span>
                <span class="bg-slate-200 text-slate-700 px-3 py-1 rounded-full text-sm">Web System Technology</span>
            </div>
        </article>
    </section>

</body>
</html>
