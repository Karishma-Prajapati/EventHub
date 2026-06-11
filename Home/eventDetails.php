<?php

include("../Authentication/db.php");

$id = $_GET['id'];

$result =
$conn->query(
"SELECT * FROM events WHERE id=$id"
);
$event =$result->fetch_assoc();
$event_id = $event['id'];
$count_query = "SELECT COUNT(*) as registered_count FROM registrations WHERE event_id = '$event_id'";
$count_result = $conn->query($count_query);
$count_row = $count_result->fetch_assoc();

// Calculate remaining seats: Total seats minus seats already booked
$event['available_seats'] = $event['total_seats'] - $count_row['registered_count'];


// 2. Fix for "$days_remaining": Calculate countdown days until the event date
$current_date = new DateTime(); // Today's date
$event_date = new DateTime($event['event_date']); // The event's date

if ($event_date > $current_date) {
    $interval = $current_date->diff($event_date);
    $days_remaining = $interval->days;
} else {
    $days_remaining = 0; // Event has already started or passed
}
$registered =
$conn->query(
"SELECT COUNT(*) as total
FROM registrations
WHERE event_id=$id"
);

$count =
$registered->fetch_assoc()['total'];

$available =
$event['total_seats'] - $count;

?>
<style>
    /* Reset and Base Styles */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    body {
        background-color: #f8fafc;
        color: #334155;
        padding: 40px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    /* Main Container Card */
    .event-container {
        background: #ffffff;
        max-width: 850px;
        width: 100%;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    /* Hero Banner Image */
    .event-hero {
        width: 100%;
        height: 380px;
        position: relative;
    }

    .event-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Content Body Wrap */
    .event-content {
        padding: 40px;
    }

    h2 {
        font-size: 32px;
        color: #0f172a;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    /* Detailed Description */
    .event-description {
        font-size: 16px;
        line-height: 1.7;
        color: #475569;
        margin-bottom: 35px;
        text-align: justify;
    }

    /* Sidebar / Metadata Grid Info Layout */
    .event-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        background: #f1f5f9;
        padding: 24px;
        border-radius: 12px;
        margin-bottom: 35px;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .meta-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        font-weight: 600;
    }

    .meta-value {
        font-size: 16px;
        color: #1e293b;
        font-weight: 600;
    }

    /* Available Seats Special Styling */
    .meta-value.seats-alert {
        color: #16a34a; /* Green if seats available */
    }

    /* Registration Footer Actions */
    .event-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 2px solid #f1f5f9;
        padding-top: 25px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .countdown-text {
        font-size: 15px;
        color: #64748b;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Interactive Action Button */
    .btn-register {
        background-color: #2563eb;
        color: #ffffff;
        text-decoration: none;
        padding: 14px 32px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        display: inline-block;
        text-align: center;
    }

    .btn-register:hover {
        background-color: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
    }

    /* Responsive adjustments */
    @media (max-width: 650px) {
        .event-content { padding: 25px; }
        h2 { font-size: 26px; }
        .event-hero { height: 240px; }
        .event-footer { flex-direction: column-reverse; align-items: stretch; }
        .btn-register { width: 100%; }
    }
</style>
<div class="event-container">
    <div class="event-hero">
        <img src="../uploads/<?php echo $event['image']; ?>" alt="Event Poster">
    </div>

    <div class="event-content">
        <h2><?php echo htmlspecialchars($event['name']); ?></h2>
        
        <p class="event-description">
            <?php echo nl2br(htmlspecialchars($event['detailed_description'])); ?>
        </p>

        <div class="event-meta-grid">
            <div class="meta-item">
                <span class="meta-label">📅 Date</span>
                <span class="meta-value"><?php echo date('F j, Y', strtotime($event['event_date'])); ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">⏰ Time</span>
                <span class="meta-value"><?php echo date('g:i A', strtotime($event['event_time'])); ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">📍 Location</span>
                <span class="meta-value"><?php echo htmlspecialchars($event['location']); ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">🎟️ Availability</span>
                <span class="meta-value seats-alert">
                    <?php echo $event['available_seats']; ?> / <?php echo $event['total_seats']; ?> Left
                </span>
            </div>
        </div>

        <div class="event-footer">
            <span class="countdown-text">
                ⏳ Starts in <?php echo $days_remaining; ?> days
            </span>
            
            <a href="../User Panel/registerEvent.php?id=<?php echo $event['id']; ?>" class="btn-register">
                Register Now
            </a>
        </div>
    </div>
</div>

<script>

var eventDate =
new Date(
"<?php echo $event['event_date']; ?> <?php echo $event['event_time']; ?>"
).getTime();

setInterval(function(){

var now = new Date().getTime();

var distance =
eventDate - now;

var days =
Math.floor(distance/(1000*60*60*24));

document.getElementById(
"countdown"
).innerHTML =
"Starts in "+days+" days";

},1000);

</script>