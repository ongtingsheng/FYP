<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MFA PIN Verification</title>
    <link rel="stylesheet" href="../public/css/mfa.css">
    <script defer src="../public/js/mfa.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <h2><i class="fas fa-key"></i> Multi-Factor Authentication</h2>
        <p class="subtitle">Enter the 6-digit PIN</p>

        <form id="mfa-form">
            <div class="pin-container">
                <input type="text" class="pin-input" maxlength="1">
                <input type="text" class="pin-input" maxlength="1">
                <input type="text" class="pin-input" maxlength="1">
                <input type="text" class="pin-input" maxlength="1">
                <input type="text" class="pin-input" maxlength="1">
                <input type="text" class="pin-input" maxlength="1">
            </div>
            <p id="error-message" class="error-message"></p>

            <button type="submit" class="verify-btn">Verify PIN</button>

            <!-- <p class="resend-text">Didn’t receive the PIN?
                <a href="#" id="resend-link">Resend</a>
            </p> -->
        </form>
    </div>

</body>

</html>