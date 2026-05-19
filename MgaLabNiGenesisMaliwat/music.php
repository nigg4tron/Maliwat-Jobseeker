**YES! Single file `index.php` - Pure PHP + Tailwind ONLY (No JS)**

```php
<?php
session_start();

interface Playable {
    public function play(): string;
    public function pause(): string;
    public function getStatus(): string;
    public function ads(): string;
}

abstract class Account {
    protected $username;
    protected $plan;

    public function __construct($username, $plan) {
        $this->username = $username;
        $this->plan = $plan;
    }

    public function getUsername() { return $this->username; }
    public function getPlan() { return $this->plan; }
}

class Free extends Account implements Playable {
    public function play(): string { return $this->username . " is playing (Free + Ads)"; }
    public function pause(): string { return $this->username . " paused music"; }
    public function getStatus(): string { return "Free"; }
    public function ads(): string { return "Premium: No Ads!"; }
}

class Premium extends Account implements Playable {
    public function play(): string { return $this->username . " is playing (Premium)"; }
    public function pause(): string { return $this->username . " paused music"; }
    public function getStatus(): string { return "Premium"; }
    public function ads(): string { return ""; }
}

// 20 SONGS LIBRARY
$songs = [
    ['id'=>1, 'title'=>'Blinding Lights', 'artist'=>'The Weeknd', 'album'=>'After Hours', 'duration'=>'3:20', 'emoji'=>'🎵'],
    ['id'=>2, 'title'=>'Levitating', 'artist'=>'Dua Lipa', 'album'=>'Future Nostalgia', 'duration'=>'3:23', 'emoji'=>'✨'],
    ['id'=>3, 'title'=>'Watermelon Sugar', 'artist'=>'Harry Styles', 'album'=>'Fine Line', 'duration'=>'2:54', 'emoji'=>'🍉'],
    ['id'=>4, 'title'=>'Bad Habits', 'artist'=>'Ed Sheeran', 'album'=>'=', 'duration'=>'3:51', 'emoji'=>'🌙'],
    ['id'=>5, 'title'=>'Dynamite', 'artist'=>'BTS', 'album'=>'BE', 'duration'=>'3:19', 'emoji'=>'💥'],
    ['id'=>6, 'title'=>'Mood', 'artist'=>'24kGoldn', 'album'=>'Single', 'duration'=>'2:20', 'emoji'=>'😎'],
    ['id'=>7, 'title'=>'Positions', 'artist'=>'Ariana Grande', 'album'=>'Positions', 'duration'=>'2:52', 'emoji'=>'👑'],
    ['id'=>8, 'title'=>'Therefore I Am', 'artist'=>'Billie Eilish', 'album'=>'Single', 'duration'=>'2:54', 'emoji'=>'🖤'],
    ['id'=>9, 'title'=>'Save Your Tears', 'artist'=>'The Weeknd', 'album'=>'After Hours', 'duration'=>'3:35', 'emoji'=>'😢'],
    ['id'=>10, 'title'=>'Heat Waves', 'artist'=>'Glass Animals', 'album'=>'Dreamland', 'duration'=>'3:58', 'emoji'=>'🌊'],
    ['id'=>11, 'title'=>'Adore You', 'artist'=>'Harry Styles', 'album'=>'Fine Line', 'duration'=>'3:27', 'emoji'=>'💖'],
    ['id'=>12, 'title'=>'Don\'t Start Now', 'artist'=>'Dua Lipa', 'album'=>'Future Nostalgia', 'duration'=>'3:03', 'emoji'=>'💃'],
    ['id'=>13, 'title'=>'Circles', 'artist'=>'Post Malone', 'album'=>'Hollywoods Bleeding', 'duration'=>'3:35', 'emoji'=>'⭕'],
    ['id'=>14, 'title'=>'ROXANNE', 'artist'=>'Arizona Zervas', 'album'=>'Single', 'duration'=>'2:22', 'emoji'=>'🔥'],
    ['id'=>15, 'title'=>'Falling', 'artist'=>'Trevor Daniel', 'album'=>'Single', 'duration'=>'2:39', 'emoji'=>'🍂'],
    ['id'=>16, 'title'=>'Golden', 'artist'=>'Harry Styles', 'album'=>'Fine Line', 'duration'=>'3:29', 'emoji'=>'⭐'],
    ['id'=>17, 'title'=>'Death Bed', 'artist'=>'Powfu', 'album'=>'Single', 'duration'=>'2:53', 'emoji'=>'💤'],
    ['id'=>18, 'title'=>'Before You Go', 'artist'=>'Lewis Capaldi', 'album'=>'Divinely Uninspired', 'duration'=>'3:35', 'emoji'=>'😔'],
    ['id'=>19, 'title'=>'Someone You Loved', 'artist'=>'Lewis Capaldi', 'album'=>'Divinely Uninspired', 'duration'=>'3:05', 'emoji'=>'💔'],
    ['id'=>20, 'title'=>'Dance Monkey', 'artist'=>'Tones and I', 'album'=>'Single', 'duration'=>'3:29', 'emoji'=>'🕺'],
];

// LOGIN/LOGOUT
if(isset($_POST['login'])){
    $_SESSION['username'] = htmlspecialchars($_POST['username']);
    $_SESSION['plan'] = $_POST['plan'];
    $_SESSION['current_song'] = 1;
    $_SESSION['is_playing'] = false;
}

if(isset($_POST['logout'])){
    session_destroy();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// PLAYER CONTROLS
if(isset($_SESSION['username'])){
    if(isset($_POST['play_song'])){ $_SESSION['current_song'] = (int)$_POST['song_id']; $_SESSION['is_playing'] = true; }
    if(isset($_POST['pause'])){ $_SESSION['is_playing'] = false; }
    if(isset($_POST['next'])){
        $_SESSION['current_song'] = min(20, $_SESSION['current_song'] + 1);
        $_SESSION['is_playing'] = true;
    }
    if(isset($_POST['previous'])){
        $_SESSION['current_song'] = max(1, $_SESSION['current_song'] - 1);
        $_SESSION['is_playing'] = true;
    }
}

// PAGE NAVIGATION
$page = $_GET['page'] ?? 'home';
$search = $_GET['search'] ?? '';

// FILTER SONGS
$filtered_songs = $search ? array_filter($songs, function($song) use($search){
    return stripos($song['title'], $search) !== false || stripos($song['artist'], $search) !== false;
}) : $songs;

$user = isset($_SESSION['username']) ? 
    ($_SESSION['plan']=='Free' ? new Free($_SESSION['username'], 'Free') : new Premium($_SESSION['username'], 'Premium')) 
    : null;

$current_song = $user ? ($songs[$_SESSION['current_song']-1] ?? $songs[0]) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotifly - PHP Spotify Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .glass { backdrop-filter: blur(20px); background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); }
        .glow-green { box-shadow: 0 0 25px rgba(34,197,94,0.4); }
        .gradient-text { background: linear-gradient(135deg, #10b981, #34d399); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-black to-gray-900 min-h-screen text-white">

<!-- SIDEBAR (Logged In Only) -->
<?php if($user): ?>
<nav class="fixed left-0 top-0 h-screen w-20 bg-black/50 glass z-50 flex flex-col py-8 space-y-8">
    <div class="flex flex-col items-center space-y-2 px-2">
        <div class="w-14 h-14 bg-gradient-to-r from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center text-2xl font-bold glow-green">S</div>
        <span class="text-xs text-center text-gray-400 font-medium w-16 truncate">Spotifly</span>
    </div>
    <div class="flex-1 flex flex-col space-y-6 items-center">
        <a href="?page=home" class="p-3 rounded-2xl flex flex-col items-center space-y-1 transition-all <?php echo $page=='home' ? 'bg-emerald-500/20 glow-green text-emerald-400' : 'hover:bg-white/10 hover:text-emerald-400 text-gray-400'; ?>">
            <i class="fa-solid fa-house text-xl"></i><span class="text-xs font-medium">Home</span>
        </a>
        <a href="?page=search" class="p-3 rounded-2xl flex flex-col items-center space-y-1 transition-all <?php echo $page=='search' ? 'bg-emerald-500/20 glow-green text-emerald-400' : 'hover:bg-white/10 hover:text-emerald-400 text-gray-400'; ?>">
            <i class="fa-solid fa-magnifying-glass text-xl"></i><span class="text-xs font-medium">Search</span>
        </a>
        <a href="?page=library" class="p-3 rounded-2xl flex flex-col items-center space-y-1 transition-all <?php echo $page=='library' ? 'bg-emerald-500/20 glow-green text-emerald-400' : 'hover:bg-white/10 hover:text-emerald-400 text-gray-400'; ?>">
            <i class="fa-solid fa-bookmark text-xl"></i><span class="text-xs font-medium">Library</span>
        </a>
    </div>
</nav>
<div class="ml-20">
<?php endif; ?>

<!-- MAIN CONTENT -->
<div class="min-h-screen <?php echo $user ? 'pt-0 pb-28' : 'flex items-center justify-center p-12'; ?>">

<?php if(!$user): // LOGIN SCREEN ?>

<div class="max-w-sm w-full glass rounded-3xl p-10 text-center glow-green">
    <div class="mb-10">
        <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-emerald-500 to-green-600 rounded-3xl flex items-center justify-center text-4xl font-bold glow-green">S</div>
        <h1 class="text-4xl font-bold gradient-text mb-3">Spotifly</h1>
        <p class="text-gray-400 text-lg">Millions of songs. Free on mobile.</p>
    </div>
    <form method="POST" class="space-y-6">
        <div>
            <input type="text" name="username" placeholder="Username" required 
                class="w-full p-4 bg-black/30 border border-white/20 rounded-2xl text-white placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
        </div>
        <select name="plan" class="w-full p-4 bg-black/30 border border-white/20 rounded-2xl text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
            <option value="Free">Free Plan</option>
            <option value="Premium">Premium Plan</option>
        </select>
        <button name="login" class="w-full bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white py-4 rounded-2xl font-semibold text-lg transition-all glow-green">
            <i class="fa-solid fa-play mr-2"></i>Continue
        </button>
    </form>
</div>

<?php else: // DASHBOARD ?>

<?php 
$plan = $user->getPlan();
$current_song_data = $current_song;
$is_playing = $_SESSION['is_playing'] ?? false;
?>

<main class="p-8 space-y-8 max-w-7xl mx-auto">
    
<?php if($page == 'home'): ?>
    <!-- HOME PAGE -->
    <header class="flex items-center justify-between mb-12">
        <div>
            <h1 class="text-5xl font-black gradient-text leading-tight">Good evening</h1>
            <p class="text-xl text-gray-400 mt-2"><?php echo $user->getUsername(); ?> • <?php echo $plan; ?></p>
        </div>
        <div class="w-16 h-16 glass rounded-2xl flex items-center justify-center text-2xl <?php echo $plan=='Premium' ? 'bg-gradient-to-r from-emerald-500 to-green-600 glow-green' : 'bg-gray-700'; ?>">
            <?php echo $plan=='Premium' ? '<i class="fa-solid fa-crown"></i>' : 'F'; ?>
        </div>
    </header>

    <!-- RECENTLY PLAYED -->
    <section>
        <h2 class="text-3xl font-bold mb-8 flex items-center"><i class="fa-solid fa-clock-rotate-left mr-4 text-emerald-400 text-2xl"></i>Recently played</h2>
        <div class="grid grid-cols-5 md:grid-cols-7 lg:grid-cols-9 gap-4">
            <?php for($i=0; $i<9; $i++): $song = $songs[array_rand($songs)]; ?>
            <form method="POST" class="glass rounded-2xl p-3 hover:bg-white/20 transition-all cursor-pointer group">
                <input type="hidden" name="song_id" value="<?php echo $song['id']; ?>">
                <input type="hidden" name="play_song" value="1">
                <button type="submit" class="w-full h-full flex flex-col items-center space-y-2 text-center p-2 rounded-xl group-hover:bg-emerald-500/20 transition-all">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500/40 to-pink-500/40 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform"><?php echo $song['emoji']; ?></div>
                    <p class="font-semibold text-sm truncate w-full"><?php echo $song['title']; ?></p>
                    <p class="text-xs text-gray-400"><?php echo $song['artist']; ?></p>
                </button>
            </form>
            <?php endfor; ?>
        </div>
    </section>

    <!-- PLAYLISTS -->
    <section>
        <h2 class="text-3xl font-bold mb-8 flex items-center"><i class="fa-solid fa-list mr-4 text-emerald-400 text-2xl"></i>Popular playlists</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php 
            $playlists = [
                ['emoji'=>'🎧', 'title'=>'Today\'s Top Hits', 'desc'=>'The biggest songs right now'],
                ['emoji'=>'🔥', 'title'=>'RapCaviar', 'desc'=>'New music from rap game'],
                ['emoji'=>'🎸', 'title'=>'Rock This', 'desc'=>'Rock hits past & present'],
                ['emoji'=>'💃', 'title'=>'Dance Party', 'desc'=>'Keep the party going']
            ];
            foreach($playlists as $playlist): ?>
            <div class="glass rounded-3xl p-8 hover:bg-white/20 transition-all cursor-pointer group glow-green hover:glow-green">
                <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-emerald-500/30 to-green-600/30 rounded-2xl flex items-center justify-center text-3xl group-hover:scale-110 transition-transform"><?php echo $playlist['emoji']; ?></div>
                <h3 class="font-bold text-xl mb-2 text-center"><?php echo $playlist['title']; ?></h3>
                <p class="text-gray-400 text-sm text-center"><?php echo $playlist['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

<?php elseif($page == 'search'): ?>
    <!-- SEARCH PAGE -->
    <div class="space-y-8">
        <form method="GET" class="glass rounded-3xl p-4 flex items-center space-x-4">
            <input type="hidden" name="page" value="search">
            <i class="fa-solid fa-magnifying-glass text-gray-400 text-xl"></i>
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search for songs, artists..." 
                class="flex-1 bg-transparent outline-none text-xl text-white placeholder-gray-400">
        </form>

        <?php if($search): ?>
        <div class="space-y-4">
            <h2 class="text-3xl font-bold flex items-center"><i class="fa-solid fa-music mr-3 text-emerald-400"></i>Songs (<?php echo count($filtered_songs); ?>)</h2>
            <?php foreach(array_slice($filtered_songs, 0, 10) as $song): ?>
            <form method="POST" class="glass p-6 rounded-2xl hover:bg-white/20 transition-all flex items-center space-x-4 cursor-pointer">
                <input type="hidden" name="song_id" value="<?php echo $song['id']; ?>">
                <input type="hidden" name="play_song" value="1">
                <button type="submit" class="flex items-center space-x-4 flex-1">
                           <div class="w-16 h-16 bg-gradient-to-br from-purple-500/40 to-pink-500/40 rounded-2xl flex items-center justify-center text-2xl"><?php echo $song['emoji']; ?></div>
                           <div class="flex-1 min-w-0">
                        <p class="font-bold text-lg"><?php echo htmlspecialchars($song['title']); ?></p>
                        <p class="text-gray-400"><?php echo htmlspecialchars($song['artist']); ?></p>
                    </div>
                    <div class="text-gray-400"><?php echo $song['duration']; ?></div>
                </button>
            </form>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-32 glass rounded-3xl p-12">
            <i class="fa-solid fa-magnifying-glass text-6xl text-gray-500 mb-8 block"></i>
            <h2 class="text-3xl font-bold text-gray-400 mb-4">Start your search</h2>
            <p class="text-gray-500 text-lg">Search for artists, songs, or podcasts</p>
        </div>
        <?php endif; ?>
    </div>

<?php elseif($page == 'library'): ?>
    <!-- LIBRARY PAGE -->
    <header class="mb-12">
        <h1 class="text-5xl font-black gradient-text">Your Library</h1>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- PLAYLISTS GRID -->
        <div class="lg:col-span-1 space-y-6">
            <h2 class="text-3xl font-bold flex items-center"><i class="fa-solid fa-grid mr-3 text-emerald-400"></i>Playlists</h2>
            <div class="space-y-4">
                <div class="glass rounded-3xl p-6 hover:bg-white/20 transition-all cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500/40 to-green-600/40 rounded-2xl flex items-center justify-center text-2xl mb-4 mx-auto">❤️</div>
                    <h3 class="font-bold text-xl text-center mb-1">Liked Songs</h3>
                    <p class="text-gray-400 text-center text-sm">45 songs</p>
                </div>
                <div class="glass rounded-3xl p-6 hover:bg-white/20 transition-all cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500/40 to-pink-500/40 rounded-2xl flex items-center justify-center text-2xl mb-4 mx-auto">📱</div>
                    <h3 class="font-bold text-xl text-center mb-1">Daily Mix 1</h3>
                    <p class="text-gray-400 text-center text-sm">Weeknd, Dua Lipa + more</p>
                </div>
                <div class="glass rounded-3xl p-6 hover:bg-white/20 transition-all cursor-pointer">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500/40 to-red-500/40 rounded-2xl flex items-center justify-center text-2xl mb-4 mx-auto">🎧</div>
                    <h3 class="font-bold text-xl text-center mb-1">Discover Weekly</h3>
                    <p class="text-gray-400 text-center text-sm">Your weekly mixtape</p>
                </div>
            </div>
        </div>

        <!-- SONGS LIST -->
        <div class="lg:col-span-2">
            <h2 class="text-3xl font-bold mb-8 flex items-center"><i class="fa-solid fa-music mr-3 text-emerald-400"></i>All Songs</h2>
            <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-4 scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-900">
                <?php foreach(array_slice($songs, 0, 15) as $song): ?>
                <form method="POST" class="glass p-5 rounded-2xl hover:bg-emerald-500/10 transition-all flex items-center space-x-4 cursor-pointer group">
                    <input type="hidden" name="song_id" value="<?php echo $song['id']; ?>">
                    <input type="hidden" name="play_song" value="1">
                    <button type="submit" class="flex items-center space-x-4 w-full group-hover:text-emerald-300 transition-all">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500/30 to-pink-500/30 rounded-xl flex items-center justify-center text-xl group-hover:bg-emerald-500/30 transition-all flex-shrink-0"><?php echo $song['emoji']; ?></div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-white truncate"><?php echo htmlspecialchars($song['title']); ?></p>
                            <p class="text-sm text-gray-400 truncate"><?php echo htmlspecialchars($song['artist']); ?></p>
                        </div>
                        <div class="text-sm text-gray-400 hidden md:block"><?php echo $song['album']; ?></div>
                        <div class="text-sm text-gray-400 ml-auto"><?php echo $song['duration']; ?></div>
                        <i class="fa-solid fa-play text-xl text-emerald-400 ml-4 opacity-0 group-hover:opacity-100 transition-all flex-shrink-0"></i>
                    </button>
                </form>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?php endif; ?>

</main>

<!-- BOTTOM PLAYER BAR -->
<footer class="fixed bottom-0 left-<?php echo $user ? '20' : '0'; ?> right-0 bg-black/80 glass backdrop-blur-xl border-t border-white/10 z-40">
    <div class="px-8 py-6">
        <form method="POST" class="flex items-center space-x-6 h-20">
            
            <?php if($current_song_data): ?>
            <!-- CURRENT SONG DISPLAY -->
            <div class="flex-shrink-0 flex items-center space-x-4">
                <div class="relative w-20 h-20 rounded-2xl overflow-hidden bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center text-3xl glow-green group">
                    <?php echo $current_song_data['emoji']; ?>
                    <?php if($is_playing): ?>
                    <div class="absolute inset-0 bg-emerald-400/30 rounded-2xl animate-ping"></div>
                    <?php endif; ?>
                </div>
                <div class="min-w-0">
                    <p class="font-bold text-lg truncate max-w-48"><?php echo htmlspecialchars($current_song_data['title']); ?></p>
                    <p class="text-sm text-gray-400 truncate max-w-48"><?php echo htmlspecialchars($current_song_data['artist']); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <!-- MAIN CONTROLS -->
            <div class="flex-1 max-w-2xl flex items-center justify-center space-x-6">
                <button name="previous" type="submit" class="w-14 h-14 glass rounded-full flex items-center justify-center hover:bg-white/20 hover:scale-105 transition-all text-xl">
                    <i class="fa-solid fa-backward-step"></i>
                </button>
                
                <?php if($is_playing): ?>
                <button name="pause" type="submit" class="w-20 h-20 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 rounded-full flex items-center justify-center text-white font-bold text-2xl glow-green transition-all shadow-2xl hover:scale-105 active:scale-95">
                    <i class="fa-solid fa-pause"></i>
                </button>
                <?php else: ?>
                <button name="play_song" type="submit" class="w-20 h-20 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 rounded-full flex items-center justify-center text-white font-bold text-2xl glow-green transition-all shadow-2xl hover:scale-105 active:scale-95">
                    <i class="fa-solid fa-play"></i>
                </button>
                <?php endif; ?>
                
                <button name="next" type="submit" class="w-14 h-14 glass rounded-full flex items-center justify-center hover:bg-white/20 hover:scale-105 transition-all text-xl">
                    <i class="fa-solid fa-forward-step"></i>
                </button>
            </div>

            <!-- STATUS & LOGOUT -->
            <div class="flex items-center space-x-4 flex-shrink-0">
                <?php if($plan=='Free' && $is_playing): ?>
                <div class="bg-yellow-500/20 text-yellow-300 px-4 py-2 rounded-full text-xs font-semibold border border-yellow-500/30 animate-pulse">
                    <i class="fa-solid fa-ad mr-1"></i><?php echo $user->ads(); ?>
                </div>
                <?php endif; ?>
                
                <span class="text-sm text-gray-500 bg-black/50 px-3 py-1 rounded-full font-medium"><?php echo $user->getStatus(); ?> Plan</span>
                
                <button name="logout" type="submit" class="w-12 h-12 glass rounded-full flex items-center justify-center hover:bg-red-500/20 hover:text-red-400 transition-all ml-auto hover:rotate-180">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </div>

            <?php if($current_song_data): ?>
            <input type="hidden" name="song_id" value="<?php echo $current_song_data['id']; ?>">
            <?php endif; ?>
        </form>
    </div>
</footer>

<?php endif; // END USER CHECK ?>

<!-- BACKGROUND EFFECTS -->
<div class="fixed inset-0 pointer-events-none overflow-hidden">
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-emerald-500/5 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    <div class="absolute top-1/2 left-1/2 w-72 h-72 bg-pink-500/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s; transform: translate(-50%, -50%);"></div>
</div>

</body>
</html>
                                       