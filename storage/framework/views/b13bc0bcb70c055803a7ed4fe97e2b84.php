<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Reset Password</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f7f7f7;
                padding: 20px;
                margin: 0;
            }

            .container {
                background-color: #ffffff;
                padding: 30px;
                border-radius: 8px;
                max-width: 600px;
                margin: auto;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                border: 1px solid #e9e9e9;
            }

            .header {
                background-color: #2c3e50;
                color: #ffffff;
                padding: 15px;
                text-align: center;
                font-size: 22px;
                border-radius: 5px 5px 0 0;
                margin: -30px -30px 20px -30px;
                /* Extends header to the container edges */
            }

            .content p {
                line-height: 1.6;
                color: #555555;
            }

            .button-container {
                text-align: center;
                /* Centers the button */
                margin: 30px 0;
            }

            .button-container a {
                color: white
            }

            .btn {
                display: inline-block;
                padding: 12px 25px;
                background-color: #2c3e50;
                /* Changed to header color */
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
                font-size: 16px;
            }

            .footer {
                margin-top: 30px;
                font-size: 12px;
                color: #888888;
                text-align: center;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                Reset Password
            </div>
            <div class="content">
                <p>Halo <b><?php echo e($name); ?></b>,</p>
                <p>Anda telah meminta untuk mereset password akun Anda. Berikut adalah kode OTP Anda:</p>
            </div>
            <div class="button-container">
                <h2 style="background-color: #2c3e50; color: white; padding: 20px; border-radius: 5px; letter-spacing: 2px; font-size: 32px;"><?php echo e($otp); ?></h2>
            </div>
            <div class="content">
                <p>Kode OTP ini berlaku sampai <b><?php echo e($expireAt); ?></b>. Jika sudah lewat, Anda harus membuat permintaan ulang.</p>
                <p>Jangan bagikan kode OTP ini kepada siapapun.</p>
                <p>Jika Anda tidak pernah meminta proses ini, abaikan email ini.</p>
            </div>
            <div class="footer">
                &copy; <?php echo e(date('Y')); ?> Aplikasi PPDB SMK
            </div>
        </div>
    </body>

</html>
<?php /**PATH C:\xampp\htdocs\bk_ukk\resources\views/emails/reset-password.blade.php ENDPATH**/ ?>