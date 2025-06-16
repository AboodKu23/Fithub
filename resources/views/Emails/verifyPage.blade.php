<!-- resources/views/emails/verify-email.blade.php -->

<div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
    <h2 style="color: #333;">Verify Your Email Address</h2>
    <p>Hello {{ $user->first_name }},</p>
    <p>Please click the button below to verify your email address:</p>

    <div style="text-align: center; margin: 20px 0;">
        <a href="{{ $verificationUrl }}"
           style="background-color: #4CAF50; color: white; padding: 12px 25px; text-decoration: none; font-weight: bold; border-radius: 5px; display: inline-block;">
            Verify Email
        </a>
    </div>

    <p>If you did not create an account, no further action is required.</p>
    <p>Best regards,<br>{{ config('app.name') }}</p>
</div>
