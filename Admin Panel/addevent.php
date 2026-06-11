<?php

session_start();

include("../Authentication/db.php");

if(!isset($_SESSION['user_id']) ||
   $_SESSION['role']!="admin"){

    die("Access Denied");
}

if(isset($_POST['submit'])){
$name=$_POST['name'];
$total_seats=$_POST['seats'];
$detailed_description=$_POST['detailed_description'];
$date=$_POST['date'];
$time=$_POST['time'];
$location=$_POST['location'];
$seats=$_POST['seats'];
$imageName = "";

if(isset($_FILES['image'])){

    $imageName =
    time()."_".$_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        "../uploads/".$imageName
    );
}

$sql="INSERT INTO events
(name,total_seats,detailed_description,event_date,event_time,location,image)
VALUES
('$name','$total_seats','$detailed_description','$date','$time','$location','$imageName')";

$conn->query($sql);

echo "Event Added Successfully";
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
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    /* Placeholder text styling */
    ::placeholder {
        color: #94a3b8;
        opacity: 1;
    }

    textarea {
        resize: vertical;
        min-height: 140px;
    }

    /* Row Layout for Side-by-Side Fields */
    .form-row {
        display: flex;
        gap: 15px;
    }

    .form-row .form-group {
        flex: 1;
    }

    /* Responsive adjustments for mobile screens */
    @media (max-width: 500px) {
        .form-row {
            flex-direction: column;
            gap: 0;
        }
    }

    /* File Input Wrapper Custom Styling */
    .file-input-wrapper {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 5px;
    }

    input[type="file"] {
        display: block;
        font-size: 14px;
        color: #64748b;
    }

    /* Submit Button */
    button[type="submit"] {
        background-color: #2563eb;
        color: white;
        border: none;
        padding: 14px 24px;
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

    /* Success Message Banner styling */
    .alert-success {
        background-color: #ecfdf5;
        color: #065f46;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #a7f3d0;
        margin-bottom: 20px;
        font-size: 15px;
        font-weight: 500;
    }
</style>

<div class="form-container">
    <h2>Add Event</h2>

    <?php if(isset($_POST['submit'])): ?>
        <div class="alert-success">Event Added Successfully</div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="image">Event Poster</label>
            <div class="file-input-wrapper">
                <input type="file" id="image" name="image" accept="image/*">
            </div>
        </div>

        <div class="form-group">
            <label for="name">Event Name</label>
            <input type="text" id="name" name="name" placeholder="Enter event name..." required>
        </div>

        <div class="form-group">
            <label for="detailed_description">Detailed Description</label>
            <textarea id="detailed_description" name="detailed_description" placeholder="Enter complete event details..."></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="date">Event Date</label>
                <input type="date" id="date" name="date">
            </div>

            <div class="form-group">
                <label for="time">Event Time</label>
                <input type="time" id="time" name="time">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="location">Location / Venue</label>
                <input type="text" id="location" name="location" placeholder="e.g. Mumbai, Auditorium B">
            </div>

            <div class="form-group">
                <label for="seats">Total Seats Available</label>
                <input type="number" id="seats" name="seats" placeholder="e.g. 50">
            </div>
        </div>

        <button type="submit" name="submit">Add Event</button>

    </form>
</div>