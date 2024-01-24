<?php
include("../connection.php");

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Access user-specific information
    $doctor_id = $_SESSION["id"];
    $username = $_SESSION["username"];
}
// Change name on profile to doctor's name
$name_sql = "SELECT name, department FROM doctors WHERE id = $doctor_id";
$name_result = $conn->query($name_sql);

if ($name_result && $name_result->num_rows > 0) {
    $row = $name_result->fetch_assoc();
    $doctor_name = $row["name"];
    $doctor_department = $row["department"];
}

// Patients Table
$pat_sql = "SELECT id, name, birthdate, gender, email, mobile_phone
            FROM `patients` WHERE doctor_id = $doctor_id";

$pat_result = mysqli_query($conn, $pat_sql);

// Register a new Patient
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $birthdate = $_POST["birthdate"];
    $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_SPECIAL_CHARS);
    $nationality = filter_input(INPUT_POST, "nationality", FILTER_SANITIZE_SPECIAL_CHARS);
    $health_insurance = filter_input(INPUT_POST, "health_insurance", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $phone_no = filter_input(INPUT_POST, "phone_no", FILTER_SANITIZE_NUMBER_INT);
    $emergency_name = filter_input(INPUT_POST, "emergency_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $emergency_no = filter_input(INPUT_POST, "emergency_no", FILTER_SANITIZE_NUMBER_INT);
    $height = filter_input(INPUT_POST, "height", FILTER_SANITIZE_NUMBER_INT);
    $weight = filter_input(INPUT_POST, "weight", FILTER_SANITIZE_NUMBER_INT);
    $allergies = filter_input(INPUT_POST, "allergies", FILTER_SANITIZE_SPECIAL_CHARS);
    $chronic_diseases = filter_input(INPUT_POST, "chronic_diseases", FILTER_SANITIZE_SPECIAL_CHARS);
    $disabilities = filter_input(INPUT_POST, "disabilities", FILTER_SANITIZE_SPECIAL_CHARS);
    $vaccines = filter_input(INPUT_POST, "vaccines", FILTER_SANITIZE_SPECIAL_CHARS);
    $medications = filter_input(INPUT_POST, "medications", FILTER_SANITIZE_SPECIAL_CHARS);


    $register_sql = "INSERT INTO `patients` (`name`, `birthdate`, `gender`, `nationality`, `health_insurance_no`,
            `email`, `mobile_phone`, `emergency_contact_name`, `emergency_contact_no`, `doctor_id`,
            `height`, `weight`, `allergies`, `chronic_diseases`, `disabilities`,
            `vaccines`, `medications`) 
            VALUES ('$name', '$birthdate', '$gender', '$nationality', '$health_insurance',
            '$email', '$phone_no', '$emergency_name', '$emergency_no', '$doctor_id',
            '$height', '$weight', '$allergies', '$chronic_diseases', '$disabilities',
            '$vaccines', '$medications')";

    if (mysqli_query($conn, $register_sql)) {
        header("Location: patients.php");
        exit();
    };
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>mediBase Portal - Patients</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.php" class="navbar-brand mx-4 mb-3">
                    <img src="img/logo.png" alt="mediBase logo" style="margin-left: -5%;">
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $doctor_name; ?></h6>
                        <span><?php echo $doctor_department; ?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a href="patients.php" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown"><i class="fa fa-hospital-user me-2"></i>Patients</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="patients.php" class="dropdown-item">My Patients</a>
                            <a href="patients.php#registerNewPatient" class="dropdown-item">Register New Patient</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="appointments.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-calendar-days me-2"></i>Appointments</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="appointments.php" class="dropdown-item">My Appointments</a>
                            <a href="patients.php#bookNewAppointment" class="dropdown-item">Book New Appointment</a>
                        </div>
                    </div>
                    <a href="messages.php" class="nav-item nav-link"><i class="fa fa-message me-2"></i>Messages</a>
                    <a href="todo.php" class="nav-item nav-link"><i class="fa fa-list-check me-2"></i>To Do</a>
                    <a href="medscape.php" class="nav-item nav-link"><i class="fa fa-book-medical me-2"></i>Medscape</a>
                    <a href="signin.php" class="nav-item nav-link"><i class="fa fa-right-from-bracket me-2"></i>Log out</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control bg-dark border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Messages</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Dr Lukas sent you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Dr Lukas sent you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Dr Lukas sent you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="messages.php" class="dropdown-item text-center">See all messages</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notifications</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo $doctor_name; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item openPopupBtn" data-popup-target="doctorInfoPopup"><i class="fa fa-user-doctor me-3"></i>My Profile</a>
                            <a href="#" class="dropdown-item openPopupBtn" data-popup-target="settingsPopup"><i class="fa fa-gear me-3"></i>Settings</a>
                            <a href="signin.php" class="dropdown-item"><i class="fa fa-right-from-bracket me-3"></i>Log Out</a>
                        </div>
                        <!-- Doctor Info Popup -->
                        <div id="doctorInfoPopup" class="popup">
                            <div class="popup-content">
                                <span class="close">&times;</span>
                                <h2>Doctor Profile Information</h2>
                                <form id="doctorProfileForm" action="your-server-side-script.php" method="post">
                                    <p><strong>First Name: </strong><input type="text" name="firstName" value="Alice"></p>
                                    <p><strong>Last Name: </strong><input type="text" name="lastName" value="Chaltikyan"></p>
                                    <p><strong>Date of Birth: </strong><span>02.01.1988</span></p>
                                    <p><strong>Gender: </strong><span>Female</span></p>
                                    <p><strong>Nationality: </strong><input type="text" name="nationality" value="Germany"></p>
                                    <p><strong>Email Address: </strong><input type="email" name="email" value="alice.chaltikyan@example.com"></p>
                                    <p><strong>Phone No.: </strong><input type="tel" name="phone" value="06428490257923"></p>
                                    <p><strong>Address: </strong><input type="text" name="address" value="Alois-Gäßl-Straße 4"></p>
                                    <p><strong>License No.: </strong><input type="text" name="licenseNo" value="8239629247"></p>
                                    <p>
                                        <label for="department"><strong>Department: </strong></label>
                                        <select name="department" id="department">
                                            <option value="Cardiology">Cardiology</option>
                                            <option value="Orthopedics">Orthopedics</option>
                                            <option value="Dermatology">Dermatology</option>
                                        </select>
                                    </p>
                                    <p>
                                        <label for="position"><strong>Position (role): </strong></label>
                                        <select name="position" id="position">
                                            <option value="MD">Medical Doctor (MD)</option>
                                            <option value="Consultant">Consultant</option>
                                        </select>
                                    </p>
                                    <p><strong>Username: </strong><input type="text" name="username" value="a.chaltikan"></p>
                                    <p><strong>Password: </strong><input type="password" name="password" value="ljXVk6bBKtvbhqK"></p>

                                    <button type="button" class="btn btn-sm btn-primary" id="editDoctorInfoBtn"><i class="fa fa-user-pen me-2"></i>Edit Info</button>
                                </form>
                            </div>
                        </div>
                        <!-- Settings Message Popup -->
                        <div id="settingsPopup" class="popup">
                            <div class="popup-content">
                                <span class="close">&times;</span>
                                <p>For settings changes, please contact the Admin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="mb-4">Patients Registered With You</h6>
                        <a class="mb-4" href="#registerNewPatient">Register New</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Patient Name</th>
                                    <th scope="col">Birthdate</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Contact Number</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($pat_result && mysqli_num_rows($pat_result) > 0) {
                                    // Fetch each row of appointment data
                                    while ($row = mysqli_fetch_assoc($pat_result)) {
                                        $dateObject = new DateTime($row['birthdate']);
                                        $formattedDate = $dateObject->format('d-m-Y');
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($formattedDate) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['mobile_phone']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<td><a class='btn btn-sm btn-primary openPopupBtn' data-popup-target='patientInfoPopup'><i class='fa fa-address-card me-2'></i>View</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No patients found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Patient Info Popup -->
                    <!-- Patient Info Form -->
                    <div id="patientInfoPopup" class="popup">
                        <div class="popup-content">
                            <span class="close">&times;</span>
                            <h2>Patient Profile Information</h2>
                            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                                <p><strong>First Name: </strong><input type="text" name="firstName" value="Lukas"></p>
                                <p><strong>Last Name: </strong><input type="text" name="lastName" value="Walker"></p>
                                <p><strong>Date of Birth: </strong><span>02.01.2001</span></p>
                                <p><strong>Gender: </strong><span>Male</span></p>
                                <p><strong>Nationality: </strong><input type="text" name="nationality" value="Sweden"></p>
                                <p><strong>Health Insurance No.: </strong><input type="text" name="insuranceNo" value="J700072634"></p>
                                <p><strong>Email Address: </strong><input type="email" name="email" value="lukas.walker@gmail.com"></p>
                                <p><strong>Phone No.: </strong><input type="tel" name="phoneNo" value="06428490257923"></p>
                                <p><strong>Emergency Contact Name: </strong><input type="text" name="emergencyContact" value="Divi Müller"></p>
                                <p><strong>Height: </strong><input type="number" name="height" value="160"> cm</p>
                                <p><strong>Weight: </strong><input type="number" name="weight" value="90"> kg</p>
                                <p><strong>Allergies: </strong><input type="text" name="allergies" value="Penicillin"></p>
                                <p><strong>Chronic Diseases: </strong><input type="text" name="chronicDiseases" value="Diabetes Type II"></p>
                                <p><strong>Disabilities: </strong><input type="text" name="disabilities" value="None"></p>
                                <p><strong>Vaccines: </strong><input type="text" name="vaccines" value="Pfizer"></p>
                                <p><strong>Medications: </strong><input type="text" name="medications" value="Paracetamol"></p>
                                <button type="button" class="btn btn-sm btn-primary" id="editPatientInfoBtn"><i class="fa fa-save me-2"></i>Edit Info</button>
                                <button type="button" class="btn btn-sm btn-primary" id="deletePatientProfileBtn"><i class="fa fa-trash me-2"></i>Delete Patient Profile</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Table End -->

            <!-- Register New Patient Start -->
            <div class="container-fluid pt-4 px-4" id="registerNewPatient">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Register New Patient</h6>
                    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Patient Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3" name="name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Date of Birth</label>
                            <div class="col-sm-10">
                                <input type="date" id="inputEmail3" name="birthdate" required>
                            </div>
                        </div>
                        <fieldset class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0">Gender</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="male">
                                    <label class="form-check-label" for="gridRadios1">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gridRadios2" value="female">
                                    <label class="form-check-label" for="gridRadios2">
                                        Female
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Nationality</label>
                            <div class="col-sm-10">
                                <!-- Country Names -->
                                <select class="form-select" id="nationality" name="nationality" required>
                                    <option value="" selected disabled>Select Country</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Aland Islands">Aland Islands</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="American Samoa">American Samoa</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Anguilla">Anguilla</option>
                                    <option value="Antarctica">Antarctica</option>
                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Aruba">Aruba</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bermuda">Bermuda</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Bouvet Island">Bouvet Island</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Cape Verde">Cape Verde</option>
                                    <option value="Cayman Islands">Cayman Islands</option>
                                    <option value="Central African Republic">Central African Republic</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Christmas Island">Christmas Island</option>
                                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo">Congo</option>
                                    <option value="Congo, Democratic Republic of the Congo">Congo, Democratic Republic of the Congo</option>
                                    <option value="Cook Islands">Cook Islands</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Curacao">Curacao</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                    <option value="Faroe Islands">Faroe Islands</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="French Guiana">French Guiana</option>
                                    <option value="French Polynesia">French Polynesia</option>
                                    <option value="French Southern Territories">French Southern Territories</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Gibraltar">Gibraltar</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Greenland">Greenland</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guadeloupe">Guadeloupe</option>
                                    <option value="Guam">Guam</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guernsey">Guernsey</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hong Kong">Hong Kong</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Isle of Man">Isle of Man</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jersey">Jersey</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                    <option value="Korea, Republic of">Korea, Republic of</option>
                                    <option value="Kosovo">Kosovo</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Macao">Macao</option>
                                    <option value="Macedonia, the Former Yugoslav Republic of">Macedonia, the Former Yugoslav Republic of</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Martinique">Martinique</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mayotte">Mayotte</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                    <option value="Moldova, Republic of">Moldova, Republic of</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montenegro">Montenegro</option>
                                    <option value="Montserrat">Montserrat</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar">Myanmar</option>
                                    <option value="Namibia">Namibia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                                    <option value="New Caledonia">New Caledonia</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="Niue">Niue</option>
                                    <option value="Norfolk Island">Norfolk Island</option>
                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau">Palau</option>
                                    <option value="Palestine">Palestine</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Pitcairn">Pitcairn</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Puerto Rico">Puerto Rico</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Reunion">Reunion</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russian Federation">Russian Federation</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Saint Barthelemy">Saint Barthelemy</option>
                                    <option value="Saint Helena">Saint Helena</option>
                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                    <option value="Saint Lucia">Saint Lucia</option>
                                    <option value="Saint Martin">Saint Martin</option>
                                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Serbia">Serbia</option>
                                    <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Sint Maarten">Sint Maarten</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                                    <option value="South Sudan">South Sudan</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                    <option value="Swaziland">Swaziland</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                    <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Timor-Leste">Timor-Leste</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tokelau">Tokelau</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                    <option value="Uruguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Viet Nam">Viet Nam</option>
                                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                                    <option value="Virgin Islands, U.s.">Virgin Islands, U.s.</option>
                                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                                    <option value="Western Sahara">Western Sahara</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Health Insurance No.</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3" name="health_insurance" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="inputEmail3" name="email" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Phone No.</label>
                            <div class="col-sm-10">
                                <input type="tel" class="form-control" id="inputEmail3" name="phone_no" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Emergency Contact Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3" name="emergency_name" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Emergency Contact No.</label>
                            <div class="col-sm-10">
                                <input type="tel" class="form-control" id="inputEmail3" name="emergency_no" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Height</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="inputEmail3" name="height" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Weight</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="inputEmail3" name="weight" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Allergies</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3" name="allergies">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Chronic Diseases</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3" name="chronic_diseases">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Disabilities</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3" name="disabilities">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Vaccines</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3" name="vaccines">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Medications</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3" name="medications">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0">Patient's Consent</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck1" required>
                                    <label class="form-check-label" for="gridCheck1">
                                        The patient hereby agrees to be registered with Dr. <?php echo $doctor_name ?>, and gives full consent.
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
            <!-- Register New Patient End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">mediBase</a>, All Rights Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed by <a href="https://github.com/so-mb/mediBase">Jouhanzasom&reg;</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
