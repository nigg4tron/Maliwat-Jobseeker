<?php
$users = ["name" =>"Gen",
          "age" => 20,
           "email" => "@ddajd",
           "hobbies"=>["games", "kk", "sfs"]
];

$users["address"] = "Nueva ecija";
$fruits = [
          ["apple" , "red"],
          ["Watermelon" , "green?"],        
          ["kiwi" , "red"]
];



$users=[
        ['name'=>'Genn', 'email'=>'ssaj2@gmail.com', 'age'=>4 ],
        ['name'=>'jan', 'email'=>'ssaj1@gmail.com', 'age'=>4 ],
        ['name'=>'Ken', 'email'=>'ssaj3@gmail.com', 'age'=>4 ]
    ];

  $output = $users[1]['email'];

  //for($i = 0; $<10; $i++);
  
  foreach($fruits as $fruits);
    echo $fruits;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Asso & Multi</title>
</head>

<body class="bg-gray-100">

    <header class="bg-blue-500 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-3xl font-semibold">PHP</h1>
        </div>
    </header>

    <div class="container mx-auto p-4 mt-4">
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">

            <!-- Output -->
            <p class="text-xl"><?= $output ?></p>

            <h2 class="text-xl font-semibold my-4">User's Array</h2>

            <pre>
<?php print_r($users); ?>
 <h2 class="text-xl font-semibold my-4">fruits</h2>

<?php print_r($fruits); ?>
            </pre>

        </div>
    </div>

</body>
</html>
