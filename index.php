<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>EventHub | Smart Event Management</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#f5f7fb;
color:#333;
transition:0.3s;
}

.dark-mode{
background:#121212;
color:white;
}

.navbar{
display:flex;
justify-content:space-between;
align-items:center;
padding:20px 8%;
background:#0f172a;
position:sticky;
top:0;
z-index:1000;
}

.logo{
font-size:28px;
font-weight:700;
color:white;
}

.nav-links a{
color:white;
text-decoration:none;
margin-left:25px;
font-weight:500;
}

.nav-links a:hover{
color:#60a5fa;
}

.dark-btn{
background:none;
border:none;
color:white;
font-size:20px;
cursor:pointer;
margin-left:20px;
}

.hero{
height:90vh;
background:
linear-gradient(
rgba(0,0,0,.65),
rgba(0,0,0,.65)
),
url('https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1600&q=80');

background-size:cover;
background-position:center;

display:flex;
justify-content:center;
align-items:center;
text-align:center;
color:white;
padding:20px;
}

.hero h1{
font-size:65px;
margin-bottom:20px;
}

.hero p{
font-size:22px;
margin-bottom:30px;
}

.btn{
display:inline-block;
padding:12px 25px;
margin:10px;
border-radius:8px;
text-decoration:none;
font-weight:600;
transition:.3s;
}

.btn-primary{
background:#2563eb;
color:white;
}

.btn-primary:hover{
background:#1d4ed8;
}

.btn-secondary{
background:white;
color:#111827;
}

.btn-secondary:hover{
background:#e5e7eb;
}

.section{
padding:80px 8%;
}

.section-title{
text-align:center;
font-size:38px;
margin-bottom:50px;
}

.search-box{
max-width:700px;
margin:auto;
display:flex;
gap:10px;
}

.search-box input{
flex:1;
padding:15px;
border:1px solid #ddd;
border-radius:10px;
}

.search-box button{
padding:15px 25px;
background:#2563eb;
color:white;
border:none;
border-radius:10px;
cursor:pointer;
}

.features{
display:grid;
grid-template-columns:
repeat(auto-fit,minmax(250px,1fr));
gap:25px;
}

.feature{
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,.08);
text-align:center;
}

.feature h3{
margin:15px 0;
}

.stats{
background:#2563eb;
color:white;
display:flex;
justify-content:space-around;
flex-wrap:wrap;
padding:70px 20px;
}

.stats div{
text-align:center;
margin:15px;
}

.stats h2{
font-size:50px;
}

.testimonials{
display:grid;
grid-template-columns:
repeat(auto-fit,minmax(300px,1fr));
gap:20px;
}

.review{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.gallery{
display:grid;
grid-template-columns:
repeat(auto-fit,minmax(250px,1fr));
gap:15px;
}

.gallery img{
width:100%;
height:250px;
object-fit:cover;
border-radius:15px;
}

.newsletter{
background:#1e293b;
color:white;
text-align:center;
padding:70px 20px;
}

.newsletter input{
padding:15px;
width:300px;
border:none;
border-radius:10px;
margin-top:20px;
}

.newsletter button{
padding:15px 25px;
border:none;
background:#2563eb;
color:white;
border-radius:10px;
cursor:pointer;
}

.footer{
background:#0f172a;
color:white;
padding:30px;
text-align:center;
}

.chat-btn{
position:fixed;
bottom:20px;
right:20px;
width:60px;
height:60px;
border-radius:50%;
background:#2563eb;
display:flex;
justify-content:center;
align-items:center;
font-size:25px;
color:white;
text-decoration:none;
}

@media(max-width:768px){

.hero h1{
font-size:40px;
}

.hero p{
font-size:18px;
}

.search-box{
flex-direction:column;
}

.navbar{
flex-direction:column;
gap:15px;
}

}

</style>

</head>

<body>

<nav class="navbar">

<div class="logo">
🎟 EventHub
</div>

<div class="nav-links">

<a href="#">Home</a>

<a href="Home/events.php">
Events
</a>

<a href="Authentication/login.php">
Login
</a>

<a href="Authentication/register.php">
Register
</a>

<button
class="dark-btn"
onclick="toggleTheme()">
🌙
</button>

</div>

</nav>

<section class="hero">

<div>

<h1>
Discover Amazing Events
</h1>

<p>
Register • Get QR Tickets • Attend Seamlessly
</p>

<a
href="Authentication/register.php"
class="btn btn-primary">
Get Started
</a>

<a
href="Home/events.php"
class="btn btn-secondary">
Explore Events
</a>

</div>

</section>

<section class="section">

<h2 class="section-title">
🔍 Search Events
</h2>

<form
action="Home/events.php"
method="GET">

<div class="search-box">

<input
type="text"
name="search"
placeholder="Search by event name or location">

<button>
Search
</button>

</div>

</form>

</section>

<section class="section">

<h2 class="section-title">
✨ Why Choose EventHub?
</h2>

<div class="features">

<div class="feature">
<h3>🎟 QR Tickets</h3>
<p>Instant QR ticket generation after registration.</p>
</div>

<div class="feature">
<h3>📧 Email Alerts</h3>
<p>Receive event confirmations and reminders.</p>
</div>

<div class="feature">
<h3>📅 Event Management</h3>
<p>Easy event creation and registration process.</p>
</div>

<div class="feature">
<h3>📊 Analytics</h3>
<p>Track registrations and event performance.</p>
</div>

</div>

</section>

<section class="stats">

<div>
<h2 id="users">0</h2>
<p>Users</p>
</div>

<div>
<h2 id="events">0</h2>
<p>Events</p>
</div>

<div>
<h2 id="tickets">0</h2>
<p>Tickets Generated</p>
</div>

</section>

<section class="section">

<h2 class="section-title">
⭐ Testimonials
</h2>

<div class="testimonials">

<div class="review">
⭐⭐⭐⭐⭐
<p>
Amazing platform for managing college events.
</p>
<h4>- Rahul Sharma</h4>
</div>

<div class="review">
⭐⭐⭐⭐⭐
<p>
QR ticket system works perfectly.
</p>
<h4>- Priya Singh</h4>
</div>

<div class="review">
⭐⭐⭐⭐⭐
<p>
Simple registration process and great UI.
</p>
<h4>- Aman Verma</h4>
</div>

</div>

</section>

<section class="section">

<h2 class="section-title">
📸 Event Gallery
</h2>

<div class="gallery">

<img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30">

<img src="https://images.unsplash.com/photo-1515169067868-5387ec356754">

<img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678">

<img src="https://images.unsplash.com/photo-1511578314322-379afb476865">

</div>

</section>

<section class="newsletter">

<h2>
📩 Subscribe For Event Updates
</h2>

<p>
Stay informed about upcoming events.
</p>

<br>

<input
type="email"
placeholder="Enter Email">

<button>
Subscribe
</button>

</section>

<footer class="footer">

<h2>EventHub</h2>

<br>

<p>
Smart Event Management Platform
</p>

<br>

<p>
© 2026 EventHub. All Rights Reserved.
</p>

</footer>

<a
href="mailto:eventhub020@gmail.com"
class="chat-btn">
💬
</a>

<script>

function toggleTheme(){
document.body.classList.toggle('dark-mode');
}

function animate(id,target){

let count=0;

let speed=Math.ceil(target/100);

let interval=setInterval(()=>{

count+=speed;

if(count>=target){
count=target;
clearInterval(interval);
}

document.getElementById(id).innerHTML=count+"+";

},20);

}

animate("users",500);
animate("events",50);
animate("tickets",1000);

</script>

</body>
</html>