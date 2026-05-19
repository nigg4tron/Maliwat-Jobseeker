<?php
$listings = [
    ['id' => 1, 'title' => 'Software Engineer', 'description' => 'We are seeking a skilled software engineer to develop high-quality solutions.', 'salary' => 80000, 'location' => '', 'tags' => ['Software Development', 'Java', 'Python']],
    ['id' => 2, 'title' => 'UI Designer', 'description' => 'We are seeking a skilled UI Designer to develop high-quality software designs.', 'salary' => 70000, 'location' => 'Japan', 'tags' => ['HTML', 'CSS', 'JavaScript']],
    ['id' => 3, 'title' => 'Gumagawa ng ref', 'description' => 'We are seeking a skilled technician to fix a high-quality ref.', 'salary' => 100000, 'location' => 'Sa Baryo Namin', 'tags' => ['Washing Machine', 'Technician', 'Fix']],
    ['id' => 4, 'title' => 'Backend Developer', 'description' => 'We are seeking a skilled Backend Developer to develop high-quality backend solutions.', 'salary' => 50000, 'location' => 'Japan', 'tags' => []],
    ['id' => 5, 'title' => 'Fullstack Developer', 'description' => 'We are seeking a skilled Full Stack Developer to develop high-quality websites.', 'salary' => 90000, 'location' => 'Japan', 'tags' => ['Full Stack', 'React', 'Node']]
];


class Person{
    public $name;
    public function greet(){
        return "heloooo";
        $this -> name;
    }
}
$person1 = new Person();
$person1->name= "Gen";
echo $person1->name;



// Helper: Format Salary
$formatSalary = fn($salary) => '$' . number_format($salary, 0);

// Helper: Generate a consistent color based on tag text
function getTagColor($tag) {
    $colors = ['bg-blue-200 text-blue-800', 'bg-green-200 text-green-800', 'bg-purple-200 text-purple-800', 'bg-orange-200 text-orange-800', 'bg-pink-200 text-pink-800', 'bg-indigo-200 text-indigo-800'];
    // Use the string length + first letter to pick a consistent index
    $index = (strlen($tag) + ord($tag[0])) % count($colors);
    return $colors[$index];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Job Board</title>
</head>
<body class="bg-gray-50 font-sans">
    <header class="bg-slate-900 text-white p-6 shadow-lg">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold tracking-tight">TechJobs Portal</h1>
        </div>
    </header>

    <div class="container mx-auto p-6 max-w-4xl">
        <?php foreach($listings as $index => $job): ?>
            <div class="mb-6 overflow-hidden transition-transform hover:scale-[1.01]">
                <div class="<?= $index % 2 === 0 ? 'bg-white' : 'bg-blue-50' ?> border border-gray-200 rounded-xl shadow-xm p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800"><?= $job['title'] ?></h2>
                            <p class="text-gray-500 mt-1 italic"><?= $job['location'] ?: 'Remote / Not Specified' ?></p>
                        </div>
                        <span class="text-green-600 font-bold text-lg">
                            <?= $formatSalary($job['salary']) ?>
                        </span>
                    </div>

                    <p class="text-gray-600 mt-4 leading-relaxed">
                        <?= $job['description'] ?>
                    </p>

                    <div class="mt-6 flex flex-wrap gap-2 items-center">
                        <span class="px-3 py-1 rounded-full text-xs font-medium <?= $job['location'] === 'Japan' ? 'bg-sky-500 text-white' : 'bg-gray-400 text-white' ?>">
                            <?= $job['location'] === 'Japan' ? 'Remote Eligible' : 'On-Site' ?>
                        </span>

                        <?php foreach($job['tags'] as $tag): ?>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold <?= getTagColor($tag) ?>">
                                <?= $tag ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>