<?php
// initialize variables
$fname = $lname = $college = $course_type = $course_name = $gender = $email = $password = $mobile = "";
$errors = [];
$data_saved = false;

// when form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // First Name
    if ($_POST["fname"] != "") {
        $fname = trim($_POST["fname"]);
        // check only alphabets
        $isValid = true;
        for ($i = 0; $i < strlen($fname); $i++) {
            if (!(($fname[$i] >= "A" && $fname[$i] <= "Z") || ($fname[$i] >= "a" && $fname[$i] <= "z"))) {
                $isValid = false;
                break;
            }
        }
        if (!$isValid) {
            $errors['fname'] = "First name must contain only letters.";
        }
    } else {
        $errors['fname'] = "First name is required.";
    }

    // Last Name
    if ($_POST["lname"] != "") {
        $lname = trim($_POST["lname"]);
        $isValid = true;
        for ($i = 0; $i < strlen($lname); $i++) {
            if (!(($lname[$i] >= "A" && $lname[$i] <= "Z") || ($lname[$i] >= "a" && $lname[$i] <= "z"))) {
                $isValid = false;
                break;
            }
        }
        if (!$isValid) {
            $errors['lname'] = "Last name must contain only letters.";
        }
    } else {
        $errors['lname'] = "Last name is required.";
    }

    // College
    if ($_POST["college"] != "") {
        $college = trim($_POST["college"]);
    } else {
        $errors['college'] = "College name is required.";
    }

    // Course Type
    if ($_POST["course_type"] != "") {
        $course_type = $_POST["course_type"];
    } else {
        $errors['course_type'] = "Course type is required.";
    }

    // Course Name
    if ($_POST["course_name"] != "") {
        $course_name = trim($_POST["course_name"]);
    } else {
        $errors['course_name'] = "Course name is required.";
    }

    // Gender
    if ($_POST["gender"] != "") {
        $gender = $_POST["gender"];
    } else {
        $errors['gender'] = "Gender is required.";
    }

    // Email (basic validation with @ and .)
    if ($_POST["email"] != "") {
        $email = trim($_POST["email"]);
        if (strpos($email, "@") === false || strpos($email, ".") === false) {
            $errors['email'] = "Invalid email format.";
        }
    } else {
        $errors['email'] = "Email is required.";
    }

    // Password (basic length and contains letters & numbers)
    if ($_POST["password"] != "") {
        $password = $_POST["password"];
        if (strlen($password) < 6) {
            $errors['password'] = "Password must be at least 6 characters.";
        } else {
            $hasUpper = false;
            $hasLower = false;
            $hasDigit = false;
            $hasSpecial = false;

            for ($i = 0; $i < strlen($password); $i++) {
                $ch = $password[$i];
                if ($ch >= "A" && $ch <= "Z") $hasUpper = true;
                else if ($ch >= "a" && $ch <= "z") $hasLower = true;
                else if ($ch >= "0" && $ch <= "9") $hasDigit = true;
                else $hasSpecial = true;
            }

            if (!$hasUpper || !$hasLower || !$hasDigit || !$hasSpecial) {
                $errors['password'] = "Password must have uppercase, lowercase, number, and special char.";
            }
        }
    } else {
        $errors['password'] = "Password is required.";
    }

    // Mobile (check exactly 10 digits)
    if ($_POST["mobile"] != "") {
        $mobile = trim($_POST["mobile"]);
        if (strlen($mobile) != 10) {
            $errors['mobile'] = "Mobile must be 10 digits.";
        } else {
            $isDigits = true;
            for ($i = 0; $i < strlen($mobile); $i++) {
                if (!($mobile[$i] >= "0" && $mobile[$i] <= "9")) {
                    $isDigits = false;
                    break;
                }
            }
            if (!$isDigits) {
                $errors['mobile'] = "Mobile must contain only digits.";
            }
        }
    } else {
        $errors['mobile'] = "Mobile number is required.";
    }

    // Save to file if no errors
    if (count($errors) == 0) {
        $data = "---- New Submission ----\n";
        $data .= "First Name: $fname\n";
        $data .= "Last Name: $lname\n";
        $data .= "College: $college\n";
        $data .= "Course Type: $course_type\n";
        $data .= "Course Name: $course_name\n";
        $data .= "Email: $email\n";
        $data .= "Password: $password\n";
        $data .= "Mobile: $mobile\n";
        $data .= "Gender: $gender\n";
        $data .= "------------------------\n\n";

        $file = fopen("submissions.txt", "a");
        fwrite($file, $data);
        fclose($file);

        $data_saved = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body { background:#f7f7f7; }
        .form-container { max-width:500px; margin:50px auto; background:#fff; padding:25px; border-radius:10px; box-shadow:0 0 10px #ccc; }
        .error { color:red; font-size:14px; }
    </style>
</head>
<body>
<div class="form-container">
    <h3 class="text-center mb-3">🎓 Student Registration Form</h3>

    <?php if ($data_saved): ?>
        <div class="alert alert-success">✅ Your information has been saved!</div>
        <h4>Saved Data:</h4>
        <ul>
            <li><b>First Name:</b> <?php echo $fname; ?></li>
            <li><b>Last Name:</b> <?php echo $lname; ?></li>
            <li><b>College:</b> <?php echo $college; ?></li>
            <li><b>Course Type:</b> <?php echo $course_type; ?></li>
            <li><b>Course Name:</b> <?php echo $course_name; ?></li>
            <li><b>Email:</b> <?php echo $email; ?></li>
            <li><b>Password:</b> <?php echo $password; ?></li>
            <li><b>Mobile:</b> <?php echo $mobile; ?></li>
            <li><b>Gender:</b> <?php echo $gender; ?></li>
        </ul>
    <?php endif; ?>

    <form method="post">
        <!-- First Name -->
        <label>First Name</label>
        <input type="text" name="fname" value="<?php echo $fname; ?>" class="form-control">
        <div class="error"><?php echo isset($errors['fname']) ? $errors['fname'] : ''; ?></div>

        <!-- Last Name -->
        <label>Last Name</label>
        <input type="text" name="lname" value="<?php echo $lname; ?>" class="form-control">
        <div class="error"><?php echo isset($errors['lname']) ? $errors['lname'] : ''; ?></div>

        <!-- College -->
        <label>College Name</label>
        <input type="text" name="college" value="<?php echo $college; ?>" class="form-control">
        <div class="error"><?php echo isset($errors['college']) ? $errors['college'] : ''; ?></div>

        <!-- Course Type -->
        <label>Course Type</label>
        <select name="course_type" class="form-control">
            <option value="">Select</option>
            <option value="UG" <?php if ($course_type=="UG") echo "selected"; ?>>UG</option>
            <option value="PG" <?php if ($course_type=="PG") echo "selected"; ?>>PG</option>
        </select>
        <div class="error"><?php echo isset($errors['course_type']) ? $errors['course_type'] : ''; ?></div>

        <!-- Course Name -->
        <label>Course Name</label>
        <input type="text" name="course_name" value="<?php echo $course_name; ?>" class="form-control">
        <div class="error"><?php echo isset($errors['course_name']) ? $errors['course_name'] : ''; ?></div>

        <!-- Gender -->
        <label>Gender</label>
        <select name="gender" class="form-control">
            <option value="">Select</option>
            <option value="Male" <?php if ($gender=="Male") echo "selected"; ?>>Male</option>
            <option value="Female" <?php if ($gender=="Female") echo "selected"; ?>>Female</option>
            <option value="Other" <?php if ($gender=="Other") echo "selected"; ?>>Other</option>
        </select>
        <div class="error"><?php echo isset($errors['gender']) ? $errors['gender'] : ''; ?></div>

        <!-- Email -->
        <label>Email</label>
        <input type="text" name="email" value="<?php echo $email; ?>" class="form-control">
        <div class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></div>

        <!-- Password -->
        <label>Password</label>
        <input type="password" name="password" value="<?php echo $password; ?>" class="form-control">
        <div class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></div>

        <!-- Mobile -->
        <label>Mobile</label>
        <input type="text" name="mobile" value="<?php echo $mobile; ?>" class="form-control">
        <div class="error"><?php echo isset($errors['mobile']) ? $errors['mobile'] : ''; ?></div>

        <br>
        <input type="submit" value="Submit" class="btn btn-primary w-100">
    </form>
</div>
</body>
</html>
