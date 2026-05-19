<?php
session_start();

interface Playable {
    public function play(): string;
    public function pause(): string;
}

abstract class Account {
    protected $username;
    protected $plan;

    public function __construct($username, $plan) {
        $this->username = $username;
        $this->plan = $plan;
    }
}

class Free extends Account implements Playable {

    public function play(): string {
        return $this->username . " is playing music (with Ads)";
    }

    public function pause(): string {
        return $this->username . " paused the music";
    }

    public function ads(): string {
        return "Advertisement: Upgrade to Premium for No Ads!";
    }
}

class Premium extends Account implements Playable {

    public function play(): string {
        return $this->username . " is playing music (Premium)";
    }

    public function pause(): string {
        return $this->username . " paused the music";
    }
}

/* LOGIN SYSTEM */

if(isset($_POST['login'])){
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['plan'] = $_POST['plan'];
}

if(isset($_POST['logout'])){
    session_destroy();
    header("Location: ".$_SERVER['PHP_SELF']);
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Spotify PHP Demo</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white flex justify-center items-center min-h-screen">

<div class="max-w-3xl w-full bg-gray-800 p-8 rounded-2xl space-y-8">

<?php if(!isset($_SESSION['username'])): ?>

<!-- LOGIN FORM -->

<div class="text-center">
<h1 class="text-3xl font-bold text-green-400">Spotify Login</h1>
<p class="text-gray-400">Login as Free or Premium</p>
</div>

<form method="post" class="space-y-4">

<input 
type="text" 
name="username" 
placeholder="Enter Username"
required
class="w-full p-2 rounded bg-gray-700"
/>

<select name="plan" class="w-full p-2 rounded bg-gray-700">
<option value="Free">Free</option>
<option value="Premium">Premium</option>
</select>

<button 
name="login"
class="w-full bg-green-500 py-2 rounded hover:bg-green-600">
Login
</button>

</form>

<?php else: ?>

<?php

$username = $_SESSION['username'];
$plan = $_SESSION['plan'];

if($plan == "Free"){
    $user = new Free($username,"Free");
}else{
    $user = new Premium($username,"Premium");
}

$play = isset($_POST['play']);
$pause = isset($_POST['pause']);

?>

<!-- PLAYER -->

<div class="text-center border-b border-gray-600 pb-4">
<h1 class="text-3xl font-bold text-green-400">Spotify Player</h1>
<p class="text-gray-400 text-sm">
User: <?php echo $username ?> | Plan: <?php echo $plan ?>
</p>
</div>

<?php if($play): ?>

<?php if($plan == "Free"): ?>
<div class="bg-yellow-300 text-black text-center py-2 rounded font-semibold">
<?php echo $user->ads(); ?>
</div>
<?php endif; ?>

<div class="mt-2 p-2 bg-gray-600 rounded text-center">
🎵 Now Playing: Song.mp3
</div>

<?php elseif($pause): ?>

<div class="mt-2 p-2 bg-gray-600 rounded text-center">
<?php echo $user->pause(); ?>
</div>

<?php endif; ?>

<form method="post" class="flex gap-2 justify-center mt-4">
<button name="play" class="bg-green-500 px-4 py-2 rounded hover:bg-green-600">Play</button>
<button name="pause" class="bg-gray-500 px-4 py-2 rounded hover:bg-gray-600">Pause</button>
<button name="logout" class="bg-red-500 px-4 py-2 rounded hover:bg-red-600">Logout</button>
</form>

<?php endif; ?>

</div>
</body>
</html> 