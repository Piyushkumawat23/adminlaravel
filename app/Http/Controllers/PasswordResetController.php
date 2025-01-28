<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    // Show the forgot password form
    public function showForgotPasswordForm()
    {
        return view('user.forgot-password'); // Create this view
    }

    // Handle sending the password reset link
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // Show the reset password form
    public function showResetPasswordForm($token)
    {
        return view('user.reset-password', ['token' => $token]); // Create this view
    }

    // Handle resetting the password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('account.login')->with('success', 'Password reset successfully.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
