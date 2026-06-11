<?php

session_start();

if(!isset($_SESSION['user_id']) ||
   $_SESSION['role']!="admin"){

    die("Access Denied");
}
include("../Authentication/db.php");

$id = $_GET['id'];

$result = $conn->query(
"SELECT * FROM events WHERE id=$id"
);

$event = $result->fetch_assoc();

if(isset($_POST['update'])){

$name=$_POST['name'];

$date=$_POST['event_date'];
$time=$_POST['event_time'];
$location=$_POST['location'];
$seats=$_POST['total_seats'];

$detailed_description=$_POST['detailed_description'];

$image = $event['image'];

if(!empty($_FILES['image']['name'])){

    if(
        !empty($event['image']) &&
        file_exists("../uploads/".$event['image'])
    ){
        unlink("../uploads/".$event['image']);
    }


    $image =
    time()."_".$_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../uploads/".$image
    );
}

$sql="UPDATE events SET
name='$name',
detailed_description='$detailed_description',
event_date='$date',
event_time='$time',
location='$location',
total_seats='$seats',
image='$image'
WHERE id=$id";

if($conn->query($sql)){
    echo "Event Updated Successfully";
}else{
    echo $conn->error;
}
}
?>
<style>
    /* Reset and Base Styles */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f4f6f9;
        color: #333;
        padding: 40px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    /* Container Card */
    .form-container {
        background: #ffffff;
        max-width: 700px;
        width: 100%;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    h2 {
        color: #2c3e50;
        margin-bottom: 25px;
        font-size: 24px;
        font-weight: 600;
        border-bottom: 2px solid #eef2f5;
        padding-bottom: 10px;
    }

    /* Form Layout Elements */
    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #4a5568;
        font-size: 14px;
    }

    /* Inputs, Textarea, and Selects */
    input[type="text"],
    input[type="date"],
    input[type="time"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 15px;
        background-color: #fff;
        color: #334155;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    input:focus,
    textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    textarea {
        resize: vertical;
        min-height: 120px;
    }

    /* Row Layout for Inline Fields (Date & Time) */
    .form-row {
        display: flex;
        gap: 15px;
    }

    .form-row .form-group {
        flex: 1;
    }

    /* Image Preview Styling */
    .image-preview-wrapper {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        padding: 15px;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 10px;
    }

    .image-preview-wrapper img {
        display: block;
        border-radius: 4px;
        max-height: 150px;
        object-fit: cover;
    }

    input[type="file"] {
        display: block;
        margin-top: 8px;
        font-size: 14px;
        color: #64748b;
    }

    /* Submit Button */
    button[type="submit"] {
        background-color: #2563eb;
        color: white;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.2s;
        margin-top: 10px;
    }

    button[type="submit"]:hover {
        background-color: #1d4ed8;
    }

    /* Notification Alert styling */
    .alert-success {
        background-color: #ecfdf5;
        color: #065f46;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #a7f3d0;
        margin-bottom: 20px;
        font-size: 15px;
    }
</style>
<div class="form-container">
    <h2>Edit Event</h2>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="name">Event Title</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event['name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="detailed_description">Detailed Description</label>
            <textarea id="detailed_description" name="detailed_description"><?php echo htmlspecialchars($event['detailed_description']); ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="event_date">Event Date</label>
                <input type="date" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>">
            </div>

            <div class="form-group">
                <label for="event_time">Event Time</label>
                <input type="time" id="event_time" name="event_time" value="<?php echo $event['event_time']; ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>">
            </div>

            <div class="form-group">
                <label for="total_seats">Total Seats Available</label>
                <input type="number" id="total_seats" name="total_seats" value="<?php echo $event['total_seats']; ?>">
            </div>
        </div>

        <div class="form-group">
            <label>Current Event Image</label>
            <div class="image-preview-wrapper">
                <?php if(!empty($event['image'])): ?>
                    <img src="../uploads/<?php echo $event['image']; ?>" alt="Event Image">
                <?php else: ?>
                    <p style="font-size: 13px; color: #94a3b8;">No image uploaded</p>
                <?php endif; ?>
            </div>
            <input type="file" name="image">
        </div>

        <button type="submit" name="update">Update Event Details</button>

    </form>
</div>